<x-mail::message>
# {{ $portalName }}

A one-time verification code has been requested for **{{ $purpose }}**.

Your code is:

# {{ $code }}

This code expires in **{{ $minutes }} minute(s)**. For your security, never share it with anyone.

If you did not request this code, you can safely ignore this email.

Thanks,<br>
{{ config('portal.ministry') }}
</x-mail::message>
