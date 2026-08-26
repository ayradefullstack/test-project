@props([
    'url',
    'color' => 'primary',
    'align' => 'center',
])

@php
    $bgColor = match ($color) {
        'success', 'green' => '#059669',
        'error', 'red' => '#dc2626',
        'teal' => '#1C9976',
        default => '#1d4ed8',
    };
@endphp

<table class="action" align="{{ $align }}" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin: 30px auto; padding: 0; text-align: {{ $align }}; width: 100%;">
<tr>
<td align="{{ $align }}" style="padding: 0;">
<table cellpadding="0" cellspacing="0" role="presentation" style="margin: 0 auto;">
<tr>
<td align="center" style="border-radius: 12px; background-color: {{ $bgColor }}; box-shadow: 0 4px 14px rgba(29, 78, 216, 0.4);">
<!--[if mso]>
<v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{ $url }}" style="height:48px;v-text-anchor:middle;width:240px;" arcsize="20%" strokecolor="{{ $bgColor }}" fillcolor="{{ $bgColor }}">
<w:anchorlock/>
<center style="color:#ffffff;font-family:sans-serif;font-size:15px;font-weight:bold;">{{ $slot }}</center>
</v:roundrect>
<![endif]-->
<!--[if !mso]><!-->
<a href="{{ $url }}" class="button" target="_blank" style="background-color: {{ $bgColor }}; border: 14px 28px; border-radius: 12px; color: #ffffff !important; display: inline-block; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 15px; font-weight: 700; letter-spacing: 0.2px; line-height: 100%; text-align: center; text-decoration: none; -webkit-text-size-adjust: none; padding: 14px 28px;">
{{ $slot }}
</a>
<!--<![endif]-->
</td>
</tr>
</table>
</td>
</tr>
</table>
