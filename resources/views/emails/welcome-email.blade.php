<x-mail::message>
# Welcome to MyInsta, {{ $userName }}

We are the next big thing, aiming to take down Instagram.
You can start by customizing your profile!
<x-mail::button :url="$profileURL">
Visit Your Profile
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
