@extends('emails.layout')

@section('title', 'New subscription: ' . $website->name . ' (' . ucfirst($website->plan) . ')')

@section('content')
<p style="margin: 0 0 16px; font-size: 16px; line-height: 24px; color: #111827;">
    Hello {{ $recipientName }},
</p>

<p style="margin: 0 0 24px; font-size: 16px; line-height: 24px; color: #374151;">
    A new subscription has been created. Details below.
</p>

<p style="margin: 0 0 8px; font-size: 14px; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Website</p>
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-bottom: 20px; font-size: 14px; color: #374151;">
    <tr>
        <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb;"><strong style="color: #6b7280;">Name</strong></td>
        <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb;">{{ $website->name }}</td>
    </tr>
    <tr>
        <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb;"><strong style="color: #6b7280;">Domain</strong></td>
        <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb;">{{ $website->domain ?: '—' }}</td>
    </tr>
    <tr>
        <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb;"><strong style="color: #6b7280;">Status</strong></td>
        <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb;">{{ ucfirst($website->status) }}</td>
    </tr>
    @if($website->description)
    <tr>
        <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb;"><strong style="color: #6b7280;">Description</strong></td>
        <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb;">{{ $website->description }}</td>
    </tr>
    @endif
</table>

<p style="margin: 0 0 8px; font-size: 14px; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Subscription</p>
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-bottom: 20px; font-size: 14px; color: #374151;">
    <tr>
        <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb;"><strong style="color: #6b7280;">Plan</strong></td>
        <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb;">{{ ucfirst($website->plan) }}</td>
    </tr>
    <tr>
        <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb;"><strong style="color: #6b7280;">Stripe status</strong></td>
        <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb;">{{ $website->stripe_status ?? '—' }}</td>
    </tr>
    <tr>
        <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb;"><strong style="color: #6b7280;">Stripe subscription ID</strong></td>
        <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb;">{{ $website->stripe_subscription_id ?? '—' }}</td>
    </tr>
    <tr>
        <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb;"><strong style="color: #6b7280;">Stripe customer ID</strong></td>
        <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb;">{{ $website->stripe_id ?? '—' }}</td>
    </tr>
    @if($website->subscription_ends_at)
    <tr>
        <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb;"><strong style="color: #6b7280;">Next billing date</strong></td>
        <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb;">{{ $website->subscription_ends_at->format('F j, Y') }}</td>
    </tr>
    @endif
</table>

<p style="margin: 0 0 8px; font-size: 14px; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Website owner</p>
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-bottom: 24px; font-size: 14px; color: #374151;">
    <tr>
        <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb;"><strong style="color: #6b7280;">Name</strong></td>
        <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb;">{{ $ownerName }}</td>
    </tr>
    <tr>
        <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb;"><strong style="color: #6b7280;">Email</strong></td>
        <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb;">{{ $ownerEmail }}</td>
    </tr>
</table>

<table role="presentation" cellspacing="0" cellpadding="0" border="0">
    <tr>
        <td style="border-radius: 6px; background-color: #65a30d;">
            <a href="{{ $websiteUrl }}" target="_blank" style="display: inline-block; padding: 12px 24px; font-size: 16px; font-weight: 600; color: #ffffff; text-decoration: none;">
                View website in admin
            </a>
        </td>
    </tr>
</table>

<p style="margin: 24px 0 0; font-size: 14px; line-height: 20px; color: #6b7280;">
    You can manage this website in the super admin panel.
</p>

<p style="margin: 16px 0 0; font-size: 16px; line-height: 24px; color: #374151;">
    Regards,<br>
    <strong>{{ config('app.name') }}</strong>
</p>
@endsection
