<?php

namespace Database\Seeders;

use App\Models\ConsentRecord;
use App\Models\Escalation;
use App\Models\FollowUp;
use App\Models\JobTicket;
use App\Models\Lead;
use App\Models\ServiceRequest;
use App\Models\Technician;
use App\Models\User;
use App\Services\FollowUpAutopilotService;
use App\Services\ModuleService;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        app(ModuleService::class)->syncFromConfig();

        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@roofingfollowflow.test'],
            [
                'name' => 'Demo Admin',
                'password' => 'password',
                'role' => User::ROLE_ADMIN,
                'phone' => '555-0100',
                'title' => 'Platform Admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $owner = User::query()->updateOrCreate(
            ['email' => 'owner@roofingfollowflow.test'],
            [
                'name' => 'Alex Rivera',
                'password' => 'password',
                'role' => User::ROLE_OWNER,
                'phone' => '555-0101',
                'title' => 'Contractor Owner',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $staff = User::query()->updateOrCreate(
            ['email' => 'staff@roofingfollowflow.test'],
            [
                'name' => 'Jordan Lee',
                'password' => 'password',
                'role' => User::ROLE_STAFF,
                'phone' => '555-0102',
                'title' => 'Ops Lead',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $techUser = User::query()->updateOrCreate(
            ['email' => 'tech@roofingfollowflow.test'],
            [
                'name' => 'Sam Ortiz',
                'password' => 'password',
                'role' => User::ROLE_TECHNICIAN,
                'phone' => '555-0103',
                'title' => 'Licensed Roofing Tech',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'customer@roofingfollowflow.test'],
            [
                'name' => 'Casey Morgan',
                'password' => 'password',
                'role' => User::ROLE_CUSTOMER,
                'phone' => '555-0104',
                'title' => 'Homeowner',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $tech = Technician::query()->updateOrCreate(
            ['email' => 'tech@roofingfollowflow.test'],
            [
                'user_id' => $techUser->id,
                'name' => 'Sam Ortiz',
                'phone' => '555-0103',
                'license_number' => 'RF-44219',
                'specialty' => 'Storm damage & shingle replacement',
                'zone' => 'North Metro',
                'status' => 'available',
                'licensed' => true,
            ]
        );

        Technician::query()->updateOrCreate(
            ['email' => 'tech2@roofingfollowflow.test'],
            [
                'name' => 'Riley Chen',
                'phone' => '555-0105',
                'license_number' => 'RF-55102',
                'specialty' => 'Commercial flat roofs',
                'zone' => 'South Metro',
                'status' => 'on_job',
                'licensed' => true,
            ]
        );

        $lead1 = Lead::query()->updateOrCreate(
            ['email' => 'pat.homeowner@example.com'],
            [
                'name' => 'Pat Homeowner',
                'phone' => '555-2001',
                'company' => null,
                'source' => 'web',
                'service_interest' => 'Architectural shingle replacement',
                'status' => 'new',
                'qualification' => 'unqualified',
                'notes' => 'Wants full roof replacement estimate after hail. Asked for insurance-friendly quote.',
                'assigned_to' => $staff->id,
            ]
        );

        $lead2 = Lead::query()->updateOrCreate(
            ['email' => 'facility@acme-shops.test'],
            [
                'name' => 'Acme Facility Manager',
                'phone' => '555-2002',
                'company' => 'Acme Shops',
                'source' => 'referral',
                'service_interest' => 'Emergency storm leak tarp-off',
                'status' => 'hot',
                'qualification' => 'qualified',
                'notes' => 'Active roof leak after overnight storm — emergency priority.',
                'assigned_to' => $owner->id,
            ]
        );

        $lead3 = Lead::query()->updateOrCreate(
            ['email' => 'roofs@retailpark.test'],
            [
                'name' => 'Retail Park Roofing Lead',
                'phone' => '555-2003',
                'company' => 'Retail Park LLC',
                'source' => 'partner',
                'service_interest' => 'Commercial flat roof coating',
                'status' => 'contacted',
                'qualification' => 'nurture',
                'notes' => 'Quote requested for TPO inspection and coating.',
                'assigned_to' => $staff->id,
            ]
        );

        foreach ([$lead1, $lead2, $lead3] as $lead) {
            ConsentRecord::query()->updateOrCreate(
                ['lead_id' => $lead->id, 'channel' => 'email'],
                [
                    'granted' => true,
                    'source' => 'web_form_checkbox',
                    'granted_at' => now()->subDays(2),
                    'evidence' => 'Checked SMS/email consent on intake form.',
                ]
            );
        }

        ConsentRecord::query()->updateOrCreate(
            ['lead_id' => $lead1->id, 'channel' => 'sms'],
            [
                'granted' => true,
                'source' => 'web_form_checkbox',
                'granted_at' => now()->subDays(2),
                'evidence' => 'SMS opt-in captured.',
            ]
        );

        $sr1 = ServiceRequest::query()->updateOrCreate(
            ['reference' => 'SR-1001'],
            [
                'lead_id' => $lead1->id,
                'title' => 'Architectural shingle replacement',
                'description' => 'Hail damage assessment and full-roof estimate.',
                'priority' => 'normal',
                'status' => 'open',
                'address' => '12 Maple Ave',
                'city' => 'Austin',
                'state' => 'TX',
                'zip' => '78701',
                'service_type' => 'Roof replacement',
                'requested_at' => now()->subDay(),
            ]
        );

        ServiceRequest::query()->updateOrCreate(
            ['reference' => 'SR-1002'],
            [
                'lead_id' => $lead2->id,
                'title' => 'Emergency storm leak tarp-off',
                'description' => 'Active leak after storm — safety tarp and dry-in.',
                'priority' => 'emergency',
                'status' => 'scheduled',
                'address' => '800 Industrial Blvd',
                'city' => 'Austin',
                'state' => 'TX',
                'zip' => '78745',
                'service_type' => 'Emergency repair',
                'requested_at' => now()->subHours(6),
            ]
        );

        JobTicket::query()->updateOrCreate(
            ['ticket_number' => 'JT-5001'],
            [
                'service_request_id' => $sr1->id,
                'technician_id' => $tech->id,
                'lead_id' => $lead1->id,
                'title' => 'Roof inspection & estimate',
                'notes' => 'Photograph hail marks and measure squares.',
                'status' => 'scheduled',
                'scheduled_for' => now()->addDay()->setHour(10),
                'estimated_hours' => 2.5,
            ]
        );

        JobTicket::query()->updateOrCreate(
            ['ticket_number' => 'JT-5002'],
            [
                'technician_id' => $tech->id,
                'lead_id' => $lead2->id,
                'title' => 'Emergency tarp-off triage',
                'notes' => 'Fall protection, tarp secure, moisture photos for insurance.',
                'status' => 'en_route',
                'scheduled_for' => now()->addHours(1),
                'estimated_hours' => 3.0,
            ]
        );

        if (FollowUp::query()->count() === 0) {
            $autopilot = app(FollowUpAutopilotService::class);
            $fu1 = $autopilot->intakeAndDraft($lead1, 'email', $staff);
            $autopilot->approve($fu1, $owner);
            $autopilot->send($fu1->fresh(), $staff);

            $fu2 = $autopilot->intakeAndDraft($lead2, 'email', $staff);
            $autopilot->handleInboundReply($lead2, 'Yes, please book tomorrow morning for the leak.', $fu2, $staff);

            $autopilot->intakeAndDraft($lead3, 'sms', $staff);
        }

        if (Escalation::query()->where('status', 'open')->count() === 0) {
            Escalation::query()->create([
                'lead_id' => $lead2->id,
                'assigned_to' => $owner->id,
                'reason' => 'Emergency qualified reply — same-day tarp-off needed',
                'priority' => 'critical',
                'status' => 'open',
                'reply_excerpt' => 'Please come today — water is coming through the ceiling.',
            ]);
        }

        unset($admin);
    }
}
