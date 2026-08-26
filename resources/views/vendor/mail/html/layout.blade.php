<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="{{ str_replace('_', '-', app()->getLocale()) }}" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
<title>{{ config('app.name') }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="color-scheme" content="dark light">
<meta name="supported-color-schemes" content="dark light">
<meta name="format-detection" content="telephone=no, date=no, address=no, email=no">
<meta name="x-apple-disable-message-reformatting">
<!--[if mso]>
<noscript>
    <xml>
        <o:OfficeDocumentSettings>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
</noscript>
<![endif]-->
<style>
/* Client-specific Styles */
#outlook a { padding: 0; }
body { width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; margin: 0; padding: 0; }
table { border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; }

@media only screen and (max-width: 620px) {
    .inner-body {
        width: 100% !important;
        border-radius: 0 !important;
        border-left: none !important;
        border-right: none !important;
    }
    .content-cell {
        padding: 28px 20px !important;
    }
    .footer {
        width: 100% !important;
        padding: 20px !important;
    }
    .feature-col {
        display: block !important;
        width: 100% !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
        margin-bottom: 12px !important;
    }
}

@media only screen and (max-width: 500px) {
    .button {
        width: 100% !important;
        text-align: center !important;
    }
}
</style>
{!! $head ?? '' !!}
</head>
<body style="margin: 0; padding: 0; background-color: #0b0f19; -webkit-font-smoothing: antialiased; word-spacing: normal;">
<div role="article" aria-roledescription="email" aria-label="{{ config('app.name') }}" lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="background-color: #0b0f19;">
<!--[if (gte mso 9)|(IE)]>
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" style="background-color: #0b0f19;">
<tr>
<td align="center" valign="top">
<![endif]-->

<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background-color: #0b0f19; margin: 0; padding: 0; width: 100%;">
<tr>
<td align="center" style="padding: 0;">
<table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin: 0; padding: 0; width: 100%;">
{!! $header ?? '' !!}

<!-- Email Body Card -->
<tr>
<td class="body" width="100%" cellpadding="0" cellspacing="0" style="padding: 0; background-color: #0b0f19;">
<!--[if (gte mso 9)|(IE)]>
<table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
<tr>
<td>
<![endif]-->
<table class="inner-body" align="center" width="600" cellpadding="0" cellspacing="0" role="presentation" style="background-color: #111827; border: 1px solid #1e293b; border-radius: 16px; margin: 0 auto; width: 600px; max-width: 600px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5);">
<!-- Top Brand Accent Border -->
<tr>
<td height="4" style="background: linear-gradient(90deg, #1B669D 0%, #1C9976 100%); font-size: 0; line-height: 0; border-top-left-radius: 15px; border-top-right-radius: 15px;">&nbsp;</td>
</tr>
<!-- Body Content -->
<tr>
<td class="content-cell" style="padding: 40px 40px 36px 40px;">
{!! Illuminate\Mail\Markdown::parse($slot) !!}

{!! $subcopy ?? '' !!}
</td>
</tr>
</table>
<!--[if (gte mso 9)|(IE)]>
</td>
</tr>
</table>
<![endif]-->
</td>
</tr>

{!! $footer ?? '' !!}
</table>
</td>
</tr>
</table>

<!--[if (gte mso 9)|(IE)]>
</td>
</tr>
</table>
<![endif]-->
</div>
</body>
</html>
