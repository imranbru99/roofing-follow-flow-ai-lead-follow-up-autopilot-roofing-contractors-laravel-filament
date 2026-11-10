<?php

namespace App\Services;

use App\Models\Lead;

/**
 * Local equivalent of imrandevbd/laravel-ai-hub — draft/classify/extract for roofing lead follow-ups.
 */
class AiHubService
{
    public function draftFollowUp(Lead $lead, string $channel = 'email'): array
    {
        $interest = $lead->service_interest ?: 'roofing service';
        $name = $lead->name;

        $subject = match ($channel) {
            'sms' => null,
            default => "Quick follow-up on your {$interest} request — RoofingFollowFlow",
        };

        $body = match ($channel) {
            'sms' => "Hi {$name}, this is your roofing contractor following up on your {$interest} inquiry. Reply YES to book an estimate, or STOP to opt out.",
            default => "Hi {$name},\n\nThanks for reaching out about {$interest}. Our licensed roofing crews can help with storm damage, shingle replacement, flat roofs, inspections, and emergency tarp-offs.\n\nReply to this email or call us to schedule a convenient estimate window. If you prefer not to hear from us, reply STOP and we will remove you immediately.\n\n— Your RoofingFollowFlow team",
        };

        $classification = $this->classifyLead($lead);

        return [
            'subject' => $subject,
            'body' => $body,
            'classification' => $classification['label'],
            'confidence' => $classification['confidence'],
        ];
    }

    public function classifyLead(Lead $lead): array
    {
        $text = strtolower(($lead->service_interest ?? '').' '.($lead->notes ?? '').' '.($lead->source ?? ''));

        if (str_contains($text, 'emergency') || str_contains($text, 'leak') || str_contains($text, 'storm') || str_contains($text, 'tarped')) {
            return ['label' => 'urgent_qualified', 'confidence' => 96.5];
        }

        if (str_contains($text, 'replacement') || str_contains($text, 'hail') || str_contains($text, 'insurance')) {
            return ['label' => 'high_value', 'confidence' => 91.0];
        }

        if (str_contains($text, 'quote') || str_contains($text, 'estimate') || str_contains($text, 'inspection')) {
            return ['label' => 'estimate_ready', 'confidence' => 88.0];
        }

        return ['label' => 'nurture', 'confidence' => 74.5];
    }

    public function classifyReply(string $reply): array
    {
        $text = strtolower($reply);

        if (preg_match('/\b(yes|interested|book|schedule|tomorrow|available)\b/', $text)) {
            return ['label' => 'qualified_hot', 'confidence' => 94.0, 'escalate' => true];
        }

        if (preg_match('/\b(stop|unsubscribe|remove|no)\b/', $text)) {
            return ['label' => 'opt_out', 'confidence' => 99.0, 'escalate' => false];
        }

        return ['label' => 'neutral', 'confidence' => 70.0, 'escalate' => false];
    }

    public function extractServiceSignals(string $text): array
    {
        $signals = [];
        foreach (['roof replacement', 'storm damage', 'shingle', 'flat roof', 'leak', 'hail', 'inspection', 'gutter'] as $term) {
            if (stripos($text, $term) !== false) {
                $signals[] = $term;
            }
        }

        return $signals;
    }
}
