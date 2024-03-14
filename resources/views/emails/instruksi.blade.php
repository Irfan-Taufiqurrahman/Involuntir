@extends('emails.app')
@section('content')

    <body style="background-color: #fff; margin: 0; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none;">
        <table border="0" cellpadding="0" cellspacing="0" class="nl-container" role="presentation"
            style="mso-table-lspace: 0; mso-table-rspace: 0; background-color: rgb(255, 255, 255);" width="100%">
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
                                                            style="mso-table-lspace: 0; mso-table-rspace: 0;"
                                                            width="100%">
                                                            <tr>
                                                                <td style="width:100%; padding: 5px; text-align: center;">
                                                                    <div style="line-height: 10px;">
                                                                        <img src="https://api.involuntir.com/images/logo/logo_involuntir2.svg" style="display: inline-block;" />
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
                                                                    style="padding-top:32px;padding-right:10px;padding-bottom:24px;padding-left:10px;">
                                                                    <div style="font-family: Arial, sans-serif">
                                                                        <div
                                                                            style="font-size: 14px; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #000000; line-height: 1.2;">
                                                                            <p style="margin: 0;">Halo
                                                                                <strong>{{ $nama }}</strong>,
                                                                            </p>
                                                                            <p style="margin: 0;">segera lakukan pembayaran untuk
                                                                                <strong>{{ $judul }} </strong>yang dibuat oleh <strong> {{ $creator_activity }} </strong>
                                                                            </p>
                                                                            <p
                                                                                style="margin: 0; mso-line-height-alt: 16.8px;">
                                                                                <br />
                                                                            </p>
                                                                            
                                                                            <p style="margin: 0;">Batas Waktu Pembayaran <strong>{{ \Carbon\Carbon::parse($hari)->translatedFormat('l, j F Y \p\u\k\u\l H:i') }}</strong>.</p>

                                                                            <p
                                                                                style="margin: 0; mso-line-height-alt: 16.8px;">
                                                                                <br />
                                                                            </p>
                                                                            <p style="margin: 0;"><strong>Rincian Pembayaran
                                                                                </strong></p>
                                                                                <p
                                                                                style="margin: 0; mso-line-height-alt: 16.8px;">
                                                                                <br />
                                                                            </p>
                                                                            <!-- Perubahan -->
                                                                            <p style="margin: 0; border-top: 1px solid #ccc; border-bottom: 1px solid #ccc; padding: 10px 15px;">
                                                                            <span style="display: inline-block; width: 50%;">Nominal:</span>
                                                                            <span style="display: inline-block; text-align: right;">Rp {{ number_format(floatval(str_replace(',', '', $nominal)), 0, ',', '.') }},00</span>
                                                                            </p>
                                                                            <p style="margin: 0; border-bottom: 1px solid #ccc; padding: 10px 15px;">
                                                                            <span style="display: inline-block; width: 50%;">Metode pembayaran:</span>
                                                                            <span style="display: inline-block; text-align: right;">{{ strtoupper($bank_name) }}</span>
                                                                            </p>
      
                                                                            <p
                                                                                style="margin: 0; mso-line-height-alt: 16.8px;">
                                                                                <br />
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    <!-- disini -->
                                                                    <div class="button-container">
                                                                    <a href="https://involuntir.com/aktivitas/kegiatanpuzzle/pembayaran/status/{{$id_donation}}">
                                                                        <button class="button" style="background-color: #0d6efd; color: #fff; padding: 10px 20px; cursor: pointer; border: none; border-radius: 20px; width: 100%;">Lihat Cara Pembayaran</button>
                                                                    </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <table border="0" cellpadding="10" cellspacing="0"
                                                            class="divider_block" role="presentation"
                                                            style="mso-table-lspace: 0; mso-table-rspace: 0;"
                                                            width="100%">
                                                            <tr>
                                                                <td>
                                                                    <div align="center">
                                                                        <table border="0" cellpadding="0"
                                                                            cellspacing="0" role="presentation"
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
                                                            style="mso-table-lspace: 0; mso-table-rspace: 0;"
                                                            width="100%">
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
                                                                                        title="Facebook"
                                                                                        width="32" /></a>
                                                                            </td>
                                                                            <td style="padding:0 2px 0 2px;"><a
                                                                                    href="https://twitter.com/pedulyindonesia"
                                                                                    target="_blank"><img alt="Twitter"
                                                                                        height="32"
                                                                                        src="https://api.peduly.com/icon/icon/email/twitter2x.png"
                                                                                        style="display: block; height: auto; border: 0;"
                                                                                        title="Twitter"
                                                                                        width="32" /></a>
                                                                            </td>
                                                                            <td style="padding:0 2px 0 2px;"><a
                                                                                    href="https://www.instagram.com/peduly_id/"
                                                                                    target="_blank"><img alt="Instagram"
                                                                                        height="32"
                                                                                        src="https://api.peduly.com/icon/icon/email/instagram2x.png"
                                                                                        style="display: block; height: auto; border: 0;"
                                                                                        title="Instagram"
                                                                                        width="32" /></a>
                                                                            </td>
                                                                            <td style="padding:0 2px 0 2px;"><a
                                                                                    href="https://www.youtube.com/channel/UCSf0CrRkqjkKT0SuHjha87Q"
                                                                                    target="_blank"><img alt="YouTube"
                                                                                        height="32"
                                                                                        src="https://api.peduly.com/icon/icon/email/youtube2x.png"
                                                                                        style="display: block; height: auto; border: 0;"
                                                                                        title="YouTube"
                                                                                        width="32" /></a>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <table border="0" cellpadding="10" cellspacing="0"
                                                            class="divider_block" role="presentation"
                                                            style="mso-table-lspace: 0; mso-table-rspace: 0;"
                                                            width="100%">
                                                            <tr>
                                                                <td>
                                                                    <div align="center">
                                                                        <table border="0" cellpadding="0"
                                                                            cellspacing="0" role="presentation"
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
                                                                                <span style="font-size:12px;">© 2022-2024
                                                                                    Involuntir. All Right
                                                                                    Reserved</span><br /><span
                                                                                    style="font-size:12px;">Gedung Siola, Koridor Co-working Space, Jl. Tunjungan No.1, Kec. Genteng, Kota SBY, Jawa Timur 60275</span>
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
