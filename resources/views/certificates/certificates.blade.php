<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asdc</title>
</head>

<body>

    <body style="background: #FFFFFF;" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
        <table width="100%" border="1" cellpadding="0" cellspacing="0" align="center" style="border:1px solid #CDCDCD">
            <tr>
                <td
                    style="background-image: url('images/Certificate-v4.jpg');background-repeat: no-repeat;background-position: center;">
                    <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="5%"></td>
                            <td width="90%">
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td height="260"></td>
                                    </tr>
                                    <tr>
                                        <td align="center"
                                            style="font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#000000; line-height:20px; font-weight: 600;">
                                           {{$user->name}}</td>
                                    </tr>
                                    <tr>
                                        <td height="240"></td>
                                    </tr>
                                </table>
                            </td>
                            <td width="5%"></td>
                        </tr>
                        <tr>

                            <td width="5%"></td>
                            <td width="87%">
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td align="right"
                                            style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#000000; line-height:20px; font-weight: 500;">
                                            {{ $test->created_at->format('d-m-Y') }}
</td>
                                    </tr>
                                </table>
                            </td>
                            <td width="8%"></td>

                        </tr>
                        <tr>
                            <td height="55"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>

</html>