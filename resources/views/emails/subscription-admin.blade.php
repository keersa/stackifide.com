@extends('emails.layout')

@section('title', 'Your subscription is active – ' . $website->name)

@section('content')
<p style="margin: 0 0 16px; font-size: 16px; line-height: 24px; color: #111827;">
    Hello {{ $recipientName }},
</p>

<p style="margin: 0 0 24px; font-size: 16px; line-height: 24px; color: #374151;">
    Your subscription for <strong>{{ $website->name }}</strong> is now active. Here's a quick summary:
</p>

<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-bottom: 24px; font-size: 15px; color: #374151;">
    <tr>
        <td style="padding: 12px 0; border-bottom: 1px solid #e5e7eb;"><strong style="color: #6b7280;">Website</strong></td>
        <td style="padding: 12px 0; border-bottom: 1px solid #e5e7eb;">{{ $website->name }}</td>
    </tr>
    <tr>
        <td style="padding: 12px 0; border-bottom: 1px solid #e5e7eb;"><strong style="color: #6b7280;">Plan</strong></td>
        <td style="padding: 12px 0; border-bottom: 1px solid #e5e7eb;">{{ ucfirst($website->plan) }}</td>
    </tr>
    @if($website->domain)
    <tr>
        <td style="padding: 12px 0; border-bottom: 1px solid #e5e7eb;"><strong style="color: #6b7280;">Domain</strong></td>
        <td style="padding: 12px 0; border-bottom: 1px solid #e5e7eb;">{{ $website->domain }}</td>
    </tr>
    @endif
</table>

<p style="margin: 0 0 24px; font-size: 16px; line-height: 24px; color: #374151;">
    You can manage your website, update content, and view billing details anytime from your admin panel.
</p>

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
    If you have any questions, just reply to this email. We're here to help.
</p>

<p style="margin: 16px 0 0; font-size: 16px; line-height: 24px; color: #374151;">
    Regards,<br>
    <strong>{{ config('app.name') }}</strong>
</p>
@endsection
