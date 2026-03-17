<?php

namespace Database\Seeders;

use App\Models\CheckinLog;
use App\Models\CustomField;
use App\Models\Event;
use App\Models\EventInterval;
use App\Models\EventTeam;
use App\Models\MarketingCampaign;
use App\Models\Participant;
use App\Models\ParticipantAnswer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class EventManagementSeeder extends Seeder
{
    /**
     * @var array<int, string>
     */
    private array $eventImageFiles = [];

    public function run(): void
    {
        $this->prepareEventImagePool();

        $users = User::factory()->count(20)->create();

        $events = Event::factory()
            ->count(6)
            ->create([
                'organizer_id' => fn () => $users->random()->id,
            ]);

        $this->assignEventImages($events);

        foreach ($events as $event) {
            $this->seedEventTeam($event, $users);
            $this->seedIntervals($event);
            $this->seedCampaigns($event);

            $customFields = $this->seedCustomFields($event);
            $participants = $this->seedParticipants($event);

            $this->seedParticipantAnswers($participants, $customFields);
            $this->seedCheckinLogs($participants, $users);
        }

        CheckinLog::factory()->count(12)->create([
            'participant_id' => null,
            'scanned_by_user_id' => fn () => $users->random()->id,
            'result' => 'invalid',
            'raw_qr_data' => fn () => (string) Str::uuid(),
        ]);
    }

    private function prepareEventImagePool(): void
    {
        $sourcePath = database_path('seeders from other project/photos');

        if (!File::exists($sourcePath)) {
            return;
        }

        $allFiles = collect(File::files($sourcePath));

        $this->eventImageFiles = $allFiles
            ->filter(fn ($file) => in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp'], true))
            ->map(fn ($file) => $file->getPathname())
            ->values()
            ->all();

        shuffle($this->eventImageFiles);

        $destination = storage_path('app/public/events_images');
        if (!File::exists($destination)) {
            File::makeDirectory($destination, 0755, true);
        }
    }

    private function assignEventImages(Collection $events): void
    {
        if (empty($this->eventImageFiles)) {
            return;
        }

        foreach ($events as $event) {
            $originalPath = array_shift($this->eventImageFiles);
            if (!$originalPath) {
                break;
            }

            $newFileName = $this->copyImageToStorage($originalPath, $event->id);
            if ($newFileName) {
                $event->update(['image' => $newFileName]);
            }
        }
    }

    private function copyImageToStorage(string $originalPath, int $eventId): ?string
    {
        $destination = storage_path('app/public/events_images');
        $extension = strtolower(pathinfo($originalPath, PATHINFO_EXTENSION));
        $fileName = sprintf('%05d_%s.%s', $eventId, Str::random(10), $extension);
        $target = $destination . DIRECTORY_SEPARATOR . $fileName;

        if (!File::exists($originalPath)) {
            return null;
        }

        File::copy($originalPath, $target);

        return $fileName;
    }

    private function seedEventTeam(Event $event, Collection $users): void
    {
        EventTeam::create([
            'event_id' => $event->id,
            'user_id' => $event->organizer_id,
            'role' => 'organizer',
            'assigned_at' => now()->subDays(random_int(10, 40)),
        ]);

        $teamSize = random_int(2, 5);

        $scanUsers = $users
            ->where('id', '!=', $event->organizer_id)
            ->shuffle()
            ->take($teamSize);

        foreach ($scanUsers as $member) {
            EventTeam::create([
                'event_id' => $event->id,
                'user_id' => $member->id,
                'role' => 'scan_only',
                'assigned_at' => now()->subDays(random_int(1, 20)),
            ]);
        }
    }

    private function seedIntervals(Event $event): void
    {
        EventInterval::factory()
            ->count(random_int(1, 3))
            ->create(['event_id' => $event->id]);
    }

    private function seedCampaigns(Event $event): void
    {
        MarketingCampaign::factory()
            ->count(random_int(1, 2))
            ->create(['event_id' => $event->id]);
    }

    /**
     * @return Collection<int, CustomField>
     */
    private function seedCustomFields(Event $event): Collection
    {
        $definitions = [
            [
                'label' => 'Company',
                'field_type' => 'text',
                'options' => null,
                'is_required' => true,
            ],
            [
                'label' => 'Dietary Restrictions',
                'field_type' => 'textarea',
                'options' => null,
                'is_required' => false,
            ],
            [
                'label' => 'T-shirt Size',
                'field_type' => 'dropdown',
                'options' => ['XS', 'S', 'M', 'L', 'XL'],
                'is_required' => false,
            ],
            [
                'label' => 'Experience Level',
                'field_type' => 'range',
                'options' => ['min' => 1, 'max' => 10, 'step' => 1],
                'is_required' => false,
            ],
            [
                'label' => 'Accept Terms',
                'field_type' => 'checkbox',
                'options' => null,
                'is_required' => true,
            ],
        ];

        $selected = collect($definitions)->shuffle()->take(random_int(3, 5))->values();

        return $selected->map(function (array $field, int $index) use ($event) {
            return CustomField::create([
                'event_id' => $event->id,
                'label' => $field['label'],
                'field_type' => $field['field_type'],
                'options' => $field['options'],
                'is_required' => $field['is_required'],
                'order' => $index + 1,
            ]);
        });
    }

    /**
     * @return Collection<int, Participant>
     */
    private function seedParticipants(Event $event): Collection
    {
        return Participant::factory()
            ->count(random_int(35, 80))
            ->create(['event_id' => $event->id]);
    }

    private function seedParticipantAnswers(Collection $participants, Collection $customFields): void
    {
        foreach ($participants as $participant) {
            foreach ($customFields as $field) {
                if (!$field->is_required && random_int(0, 100) < 25) {
                    continue;
                }

                ParticipantAnswer::create([
                    'participant_id' => $participant->id,
                    'custom_field_id' => $field->id,
                    'value' => $this->valueForField($field),
                ]);
            }
        }
    }

    private function seedCheckinLogs(Collection $participants, Collection $users): void
    {
        foreach ($participants as $participant) {
            if ($participant->checked_in_at) {
                CheckinLog::create([
                    'participant_id' => $participant->id,
                    'scanned_by_user_id' => $users->random()->id,
                    'result' => 'success',
                    'raw_qr_data' => $participant->qr_code_token,
                    'scanned_at' => $participant->checked_in_at,
                ]);

                if (random_int(0, 100) < 15) {
                    CheckinLog::create([
                        'participant_id' => $participant->id,
                        'scanned_by_user_id' => $users->random()->id,
                        'result' => 'duplicate',
                        'raw_qr_data' => $participant->qr_code_token,
                        'scanned_at' => now()->subMinutes(random_int(1, 300)),
                    ]);
                }
            } elseif (random_int(0, 100) < 20) {
                CheckinLog::create([
                    'participant_id' => $participant->id,
                    'scanned_by_user_id' => $users->random()->id,
                    'result' => fake()->randomElement(['invalid', 'expired']),
                    'raw_qr_data' => (string) Str::uuid(),
                    'scanned_at' => now()->subHours(random_int(1, 48)),
                ]);
            }
        }
    }

    private function valueForField(CustomField $field): string
    {
        return match ($field->field_type) {
            'text' => fake()->company(),
            'textarea' => fake()->sentence(10),
            'dropdown' => (string) collect($field->options)->random(),
            'range' => (string) random_int(
                data_get($field->options, 'min', 1),
                data_get($field->options, 'max', 10)
            ),
            'checkbox' => fake()->boolean(90) ? 'true' : 'false',
            default => fake()->word(),
        };
    }
}
