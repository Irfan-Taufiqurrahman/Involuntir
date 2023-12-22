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
                                                                <td
                                                                    style="width:100%;padding-right:0px;padding-left:0px;padding-top:5px;">
                                                                    <div style="line-height:10px;display:flex;justify-content:center;">
                                                                        <svg class="self-center h-5"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="145" height="24" fill="none"
                                                                            viewBox="0 0 145 24">
                                                                            <path fill="#212121"
                                                                                d="M19.636 9.922h.255a5.166 5.166 0 011.975-1.848c.828-.467 1.773-.7 2.835-.7.976 0 1.837.159 2.58.477a4.53 4.53 0 011.815 1.37c.489.573.85 1.274 1.083 2.102.255.807.382 1.71.382 2.707v9.46H26.39v-8.95c0-1.125-.255-1.953-.765-2.484-.488-.552-1.21-.828-2.165-.828-.574 0-1.083.127-1.53.382a3.502 3.502 0 00-1.114.987c-.298.404-.531.892-.7 1.465a6.842 6.842 0 00-.224 1.784v7.644H15.72V7.883h3.917v2.039zM31.73 7.883h4.746l3.886 9.938h.223l3.917-9.938h4.714l-6.72 15.607h-4.11L31.73 7.883zm26.309-.51c1.21 0 2.314.213 3.312.638a7.37 7.37 0 012.612 1.72 7.367 7.367 0 011.72 2.611c.425 1.02.637 2.134.637 3.345 0 1.21-.212 2.325-.637 3.344a7.694 7.694 0 01-1.72 2.644c-.722.722-1.593 1.295-2.612 1.72-.998.403-2.102.605-3.312.605s-2.325-.202-3.345-.605a8.469 8.469 0 01-2.611-1.72 8.373 8.373 0 01-1.72-2.644c-.404-1.02-.606-2.134-.606-3.344s.202-2.325.605-3.345c.425-1.019.999-1.89 1.72-2.611a7.773 7.773 0 012.612-1.72c1.02-.425 2.134-.637 3.345-.637zm0 12.773c.53 0 1.04-.096 1.529-.287.51-.212.955-.51 1.337-.892.383-.382.68-.849.892-1.401.234-.552.35-1.178.35-1.88 0-.7-.116-1.326-.35-1.878a3.962 3.962 0 00-.892-1.402 3.714 3.714 0 00-1.337-.86 3.794 3.794 0 00-1.53-.318c-.551 0-1.071.106-1.56.318a3.782 3.782 0 00-1.306.86c-.382.382-.69.85-.924 1.402-.212.552-.318 1.178-.318 1.879 0 .7.106 1.327.318 1.879.234.552.542 1.02.924 1.402.382.382.818.679 1.306.891a4.246 4.246 0 001.56.287zm10.807 3.344V.685h4.172V23.49h-4.172zm18.542-2.038h-.254a5.415 5.415 0 01-1.975 1.88c-.828.445-1.773.668-2.835.668-1.975 0-3.45-.605-4.427-1.816-.956-1.21-1.434-2.824-1.434-4.84v-9.46h4.173v8.95c0 1.125.244 1.964.733 2.516.51.53 1.242.796 2.197.796.574 0 1.072-.117 1.497-.35a3.563 3.563 0 001.115-.988c.319-.424.552-.913.7-1.465.17-.573.256-1.178.256-1.816V7.883h4.172V23.49h-3.918v-2.038zm11.41-11.53h.255a5.169 5.169 0 011.975-1.848c.828-.467 1.773-.7 2.834-.7.977 0 1.837.159 2.58.477a4.525 4.525 0 011.816 1.37c.488.573.849 1.274 1.083 2.102.255.807.382 1.71.382 2.707v9.46h-4.172v-8.95c0-1.125-.255-1.953-.765-2.484-.488-.552-1.21-.828-2.166-.828-.573 0-1.083.127-1.529.382a3.506 3.506 0 00-1.114.987c-.298.404-.531.892-.701 1.465a6.846 6.846 0 00-.223 1.784v7.644H94.88V7.883h3.918v2.039zm15.283 1.529h-2.739V7.883h2.739V3.106h4.173v4.777h3.822v3.568h-3.822v6.051c0 .361.031.701.095 1.02.085.297.234.552.446.764.298.34.722.51 1.274.51.361 0 .648-.032.86-.096.213-.085.414-.191.605-.318l1.179 3.662a6.35 6.35 0 01-1.593.51 8.224 8.224 0 01-1.847.191c-.786 0-1.497-.117-2.134-.35a4.74 4.74 0 01-1.561-1.02c-.998-.955-1.497-2.314-1.497-4.076V11.45zm13.545-5.83a2.97 2.97 0 01-1.051-.19 3.373 3.373 0 01-.86-.574 3.376 3.376 0 01-.573-.86 2.794 2.794 0 01-.192-1.05c0-.383.064-.733.192-1.052a2.88 2.88 0 01.573-.828c.255-.255.541-.446.86-.573.34-.149.69-.223 1.051-.223.743 0 1.38.265 1.911.796.531.51.796 1.136.796 1.88 0 .742-.265 1.38-.796 1.91a2.662 2.662 0 01-1.911.765zm-2.07 17.87V7.882h4.172V23.49h-4.172zm7.988-15.608h3.918v2.166h.254c.192-.382.446-.732.765-1.051a5.633 5.633 0 011.051-.828 5.598 5.598 0 011.274-.542 5.194 5.194 0 011.37-.19c.551 0 1.019.052 1.401.159a3.78 3.78 0 011.019.414l-1.115 3.79a3.4 3.4 0 00-.859-.287c-.298-.085-.669-.127-1.115-.127a3.44 3.44 0 00-1.561.35c-.467.213-.871.52-1.21.924a4.84 4.84 0 00-.765 1.433 5.72 5.72 0 00-.255 1.752v7.644h-4.172V7.883zM5.574 12.342l5.574 11.148H0l5.574-11.148z"
                                                                                opacity="0.9"></path>
                                                                            <path fill="#0288D1"
                                                                                d="M5.574 11.148A5.574 5.574 0 105.574 0a5.574 5.574 0 000 11.148z">
                                                                            </path>
                                                                        </svg>
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
                                                                            <p style="margin: 0;">Terima kasih atas donasi
                                                                                kamu untuk
                                                                                <strong>{{ $judul }}.</strong>
                                                                            </p>
                                                                            <p
                                                                                style="margin: 0; mso-line-height-alt: 16.8px;">
                                                                                <br />
                                                                            </p>
                                                                            <p style="margin: 0;">Segera lakukan pembayaran
                                                                                donasi sebelum <strong>{{ $hari }}
                                                                                    .</strong></p>
                                                                            <p
                                                                                style="margin: 0; mso-line-height-alt: 16.8px;">
                                                                                <br />
                                                                            </p>
                                                                            <p style="margin: 0;"><strong>Rincian Donasi
                                                                                </strong></p>
                                                                                <p
                                                                                style="margin: 0; mso-line-height-alt: 16.8px;">
                                                                                <br />
                                                                            </p>
                                                                            <p style="margin: 0;"> Nominal :
                                                                                {{ $nominal }}<br/>
                                                                            </p>
                                                                            <p style="margin: 0;"> Metode pembayaran :
                                                                                {{ $bank_name }}<br/>
                                                                            </p>  
                                                                              
                                                                            <p
                                                                                style="margin: 0; mso-line-height-alt: 16.8px;">
                                                                                <br />
                                                                            </p>
                                                                            <p style="margin: 0;">Ketika donasi berhasil,
                                                                                kamu akan mendapatkan notifikasi via email.
                                                                                Apabila hingga <strong>{{ $hari }}
                                                                                    pukul 23.59 WIB</strong> donasi belum
                                                                                kami
                                                                                terima, maka <strong>Donasi akan dibatalkan
                                                                                    otomatis oleh sistem.</strong></p>
                                                                        </div>
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
