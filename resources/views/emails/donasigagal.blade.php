@extends('emails.app')
@section('content')

    <body style="background-color: #fff; margin: 0; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none;">
        <table border="0" cellpadding="0" cellspacing="0" class="nl-container" role="presentation"
            style="mso-table-lspace: 0; mso-table-rspace: 0; background-color: #fff;" width="100%">
            <tbody>
                <tr>
                    <td>
                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-1"
                            role="presentation" style="mso-table-lspace: 0; mso-table-rspace: 0;" width="100%">
                            <tbody>
                                <tr>
                                    <td>
                                        <table align="center" border="0" cellpadding="0" cellspacing="0"
                                            class="row-content stack" role="presentation"
                                            style="mso-table-lspace: 0; mso-table-rspace: 0;" width="500">
                                            <tbody>
                                                <tr>
                                                    <th class="column"
                                                        style="mso-table-lspace: 0; mso-table-rspace: 0; font-weight: 400; text-align: left; vertical-align: top;"
                                                        width="100%">
                                                        <table border="0" cellpadding="0" cellspacing="0"
                                                            class="image_block" role="presentation"
                                                            style="mso-table-lspace: 0; mso-table-rspace: 0;" width="100%">
                                                            <tr>
                                                                <td
                                                                    style="width:100%;padding-right:0px;padding-left:0px;padding-top:5px;">
                                                                    <div style="line-height:10px"><img
                                                                            src="https://api.peduly.com/icon/icon/peduly-mini.png"
                                                                            style="display: block; height: auto; border: 0; width: 137px; max-width: 100%;"
                                                                            width="137" /></div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <table border="0" cellpadding="0" cellspacing="0"
                                                            class="text_block" role="presentation"
                                                            style="mso-table-lspace: 0; mso-table-rspace: 0; word-break: break-word;"
                                                            width="100%">
                                                            <tr>
                                                                <td
                                                                    style="padding-top:32px;padding-right:10px;padding-bottom:24px;padding-left:10px;">
                                                                    <div style="font-family: Arial, sans-serif">
                                                                        <div
                                                                            style="font-size: 14px; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #000000; line-height: 1.2;">
                                                                            <p style="margin: 0;">Halo
                                                                                <strong>{{ $nama_donatur }}</strong>,
                                                                            </p>
                                                                            <br>
                                                                            <p style="margin: 0;">Donasi kamu <strong
                                                                                    style="color: red;">dibatalkan</strong>
                                                                                untuk
                                                                                penggalangan
                                                                                <strong>{{ $judul }} </strong>dari
                                                                                @if (isset($nama_fundraiser))
                                                                                <strong>{{ $nama_fundraiser }}.</strong>
                                                                                @endif
                                                                            </p>
                                                                            <p
                                                                                style="margin: 0; mso-line-height-alt: 16.8px;">
                                                                                <br />
                                                                            </p>
                                                                            <p style="margin: 0;"><strong>Rincian
                                                                                    Donasi</strong></p>
                                                                            <p
                                                                                style="margin: 0; mso-line-height-alt: 16.8px;">
                                                                                <br />
                                                                            </p>
                                                                            <p style="margin: 0;">Nominal Donasi: <strong>Rp
                                                                                    {{ $nominal }}</strong><br />Metode
                                                                                Pembayaran:
                                                                                <strong>{{ $metode }}</strong>
                                                                            </p>
                                                                            <p
                                                                                style="margin: 0; mso-line-height-alt: 16.8px;">
                                                                                <br />
                                                                            </p>
                                                                        </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <table border="0" cellpadding="10" cellspacing="0"
                                                            class="divider_block" role="presentation"
                                                            style="mso-table-lspace: 0; mso-table-rspace: 0;" width="100%">
                                                            <tr>
                                                                <td>
                                                                    <div align="center">
                                                                        <table border="0" cellpadding="0" cellspacing="0"
                                                                            role="presentation"
                                                                            style="mso-table-lspace: 0; mso-table-rspace: 0;"
                                                                            width="100%">
                                                                            <tr>
                                                                                <td class="divider_inner"
                                                                                    style="font-size: 1px; line-height: 1px; border-top: 1px solid #C4C4C4;">
                                                                                    <span></span>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <table border="0" cellpadding="0" cellspacing="0"
                                                            class="text_block" role="presentation"
                                                            style="mso-table-lspace: 0; mso-table-rspace: 0; word-break: break-word;"
                                                            width="100%">
                                                            <tr>
                                                                <td
                                                                    style="padding-top:10px;padding-right:10px;padding-bottom:26px;padding-left:10px;">
                                                                    <div style="font-family: Arial, sans-serif">
                                                                        <div
                                                                            style="font-size: 14px; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #717171; line-height: 1.2;">
                                                                            <p style="margin: 0; font-size: 14px;"><span
                                                                                    style="font-size:12px;">Email dibuat
                                                                                    otomatis. Mohon tidak mengirimkan
                                                                                    balasan ke email ini. Jika membutuhkan
                                                                                    bantuan silahkan hubungi <a
                                                                                        href="https://peduly.com/kontak"
                                                                                        rel="noopener"
                                                                                        style="text-decoration: underline; color: #e6523b;"
                                                                                        target="_blank">Kontak
                                                                                        Kami</a>. </span></p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <table border="0" cellpadding="10" cellspacing="0"
                                                            class="text_block" role="presentation"
                                                            style="mso-table-lspace: 0; mso-table-rspace: 0; word-break: break-word;"
                                                            width="100%">
                                                            <tr>
                                                                <td>
                                                                    <div style="font-family: Arial, sans-serif">
                                                                        <div
                                                                            style="font-size: 14px; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #717171; line-height: 1.2;">
                                                                            <p style="margin: 0; text-align: center;">Ikuti
                                                                                kami</p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <table border="0" cellpadding="10" cellspacing="0"
                                                            class="social_block" role="presentation"
                                                            style="mso-table-lspace: 0; mso-table-rspace: 0;" width="100%">
                                                            <tr>
                                                                <td>
                                                                    <table align="center" border="0" cellpadding="0"
                                                                        cellspacing="0" class="social-table"
                                                                        role="presentation"
                                                                        style="mso-table-lspace: 0; mso-table-rspace: 0;"
                                                                        width="144px">
                                                                        <tr>
                                                                            <td style="padding:0 2px 0 2px;"><a
                                                                                    href="https://www.facebook.com/pedulysurabaya"
                                                                                    target="_blank"><img alt="Facebook"
                                                                                        height="32"
                                                                                        src="https://api.peduly.com/icon/icon/email/facebook2x.png"
                                                                                        style="display: block; height: auto; border: 0;"
                                                                                        title="Facebook" width="32" /></a>
                                                                            </td>
                                                                            <td style="padding:0 2px 0 2px;"><a
                                                                                    href="https://twitter.com/pedulyindonesia"
                                                                                    target="_blank"><img alt="Twitter"
                                                                                        height="32"
                                                                                        src="https://api.peduly.com/icon/icon/email/twitter2x.png"
                                                                                        style="display: block; height: auto; border: 0;"
                                                                                        title="Twitter" width="32" /></a>
                                                                            </td>
                                                                            <td style="padding:0 2px 0 2px;"><a
                                                                                    href="https://www.instagram.com/pedulyindonesia/"
                                                                                    target="_blank"><img alt="Instagram"
                                                                                        height="32"
                                                                                        src="https://api.peduly.com/icon/icon/email/instagram2x.png"
                                                                                        style="display: block; height: auto; border: 0;"
                                                                                        title="Instagram" width="32" /></a>
                                                                            </td>
                                                                            <td style="padding:0 2px 0 2px;"><a
                                                                                    href="https://www.youtube.com/channel/UCSf0CrRkqjkKT0SuHjha87Q"
                                                                                    target="_blank"><img alt="YouTube"
                                                                                        height="32"
                                                                                        src="https://api.peduly.com/icon/icon/email/youtube2x.png"
                                                                                        style="display: block; height: auto; border: 0;"
                                                                                        title="YouTube" width="32" /></a>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <table border="0" cellpadding="10" cellspacing="0"
                                                            class="divider_block" role="presentation"
                                                            style="mso-table-lspace: 0; mso-table-rspace: 0;" width="100%">
                                                            <tr>
                                                                <td>
                                                                    <div align="center">
                                                                        <table border="0" cellpadding="0" cellspacing="0"
                                                                            role="presentation"
                                                                            style="mso-table-lspace: 0; mso-table-rspace: 0;"
                                                                            width="100%">
                                                                            <tr>
                                                                                <td class="divider_inner"
                                                                                    style="font-size: 1px; line-height: 1px; border-top: 1px solid #C4C4C4;">
                                                                                    <span></span>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <table border="0" cellpadding="0" cellspacing="0"
                                                            class="text_block" role="presentation"
                                                            style="mso-table-lspace: 0; mso-table-rspace: 0; word-break: break-word;"
                                                            width="100%">
                                                            <tr>
                                                                <td
                                                                    style="padding-top:10px;padding-right:10px;padding-bottom:15px;padding-left:10px;">
                                                                    <div style="font-family: sans-serif">
                                                                        <div
                                                                            style="font-size: 14px; color: #717171; line-height: 1.2; font-family: Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                                            <p
                                                                                style="margin: 0; font-size: 14px; text-align: center;">
                                                                                <span style="font-size:12px;">© 2018-2021
                                                                                    Peduly. All Right
                                                                                    Reserved</span><br /><span
                                                                                    style="font-size:12px;">Jl. Kertajaya
                                                                                    No. 72, Surabaya, 60292</span>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </td>
                </tr>
            </tbody>
        </table><!-- End -->
    </body>
@endsection
