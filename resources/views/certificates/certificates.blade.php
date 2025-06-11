<!DOCTYPE html>
<html lang="en">
  <head>
    <title>National Automobile Olympiad Quiz Certificate</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
<body style="background-color: #FFFFFF;" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
  <table width="595" border="0" cellpadding="0" cellspacing="0" align="center" style="background: url('images/nao-cerificate.jpg') no-repeat center;">
    <tr>
      <td style="padding: 0; margin: 0; border:0">
        <table width="100%" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td width="20"></td>
            <td>
              <table width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                 <td height="300"></td>
                </tr>
                <tr>
                  <td
                    style="font-size:26px;font-family: Arial, Helvetica, sans-serif;line-height: 30px;font-weight: 500;text-align: center;color:#835A2A">
                    {{$user->name}}</td>
                </tr>
                <tr>
                   <td height="90"></td>
                </tr>
                <tr>
                  <td
                    style="font-size:18px;font-family: Arial, Helvetica, sans-serif;line-height: 23px;font-weight: 500;text-align: center;color:#212121">
                    {{ $test->created_at->format('d-m-Y') }}</td>
                </tr>
                <tr>
                   <td height="140"></td>
                </tr>
              </table>
            </td>
            <td width="20"></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>

</html>


