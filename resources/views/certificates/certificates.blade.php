<!DOCTYPE html>
<html lang="en">

<head>
  <title>National Automobile Olympiad Quiz Certificate</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="background-color: #FFFFFF;" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
  <table width="595" border="0" cellpadding="0" cellspacing="0" border="0" align="center"
    style="background: url(images/nao-certificate.jpg) no-repeat top center;">
    <tr>
      <td style="padding: 0; margin: 0; border:0">
        <table width="100%" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td width="30"></td>
            <td>
              <table width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                  <td height="250"></td>
                </tr>
                <tr>
                  <td
                    style="font-size:28px;font-family: Arial, Helvetica, sans-serif; line-height: 30px; font-weight: 500;text-align: center;color:#835A2A">
                    {{$user->name}}</td>
                </tr>
                <tr>
                  <td height="15"></td>
                </tr>
                <tr>
                  <td
                    style="font-size:20px;font-family: Arial, Helvetica, sans-serif;line-height: 23px;font-weight: 500;text-align: center;color:#363636">
                    Class : {{ $class}}<sup>th</sup></td>
                </tr>
                <tr>
                  <td height="15"></td>
                </tr>
                <tr>
                  <td
                    style="font-size:18px;font-family: Arial, Helvetica, sans-serif;line-height: 23px;font-weight: 500;text-align: center;color:#363636">
                    School : {{ $school_name }}</td>
                </tr>
                <tr>
                  <td height="20"></td>
                </tr>
                <tr>
                  <td
                    style="font-size:16px;font-family: Arial, Helvetica, sans-serif;line-height: 24px;font-weight: 500;text-align: center;color:#363636;text-align: center;">
                    Has successfully completed Round 1 of the National Automobile Olympiad <br>(NAO) 2025 conducted by
                    Automotive Skills Development Council (ASDC) <br>in collaboration with Central Board of Secondary
                    Education (CBSE)</td>
                </tr>
                <tr>
                  <td height="15"></td>
                </tr>
                <tr>
                  <td>
                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tr>
                        <td width="100"></td>
                        <td>
                          <table width="100%" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                              <td width="49%">
                                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                  <tr>
                                    <td
                                      style="font-size:16px;font-family: Arial, Helvetica, sans-serif;line-height: 24px;font-weight: 600;text-align: left;color:#33312A;text-align: left;">
                                      School Code :</td>
                                  </tr>
                                </table>
                              </td>
                              <td witdth="2%"></td>
                              <td width="49%">
                                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                  <tr>
                                    <td
                                      style="font-size:16px;font-family: Arial, Helvetica, sans-serif;line-height: 24px;font-weight: 500;text-align: right;color:#33312A;text-align:right;">
                                      {{ $school_code }}</td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                            <tr>
                              <td height="10" colspan="3"></td>
                            </tr>
                            <tr>
                              <td width="49%">
                                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                  <tr>
                                    <td
                                      style="font-size:16px;font-family: Arial, Helvetica, sans-serif;line-height: 24px;font-weight: 600;text-align: left;color:#33312A;text-align: left;">
                                      Student Code :</td>
                                  </tr>
                                </table>
                              </td>
                              <td witdth="2%"></td>
                              <td width="49%">
                                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                  <tr>
                                    <td
                                      style="font-size:16px;font-family: Arial, Helvetica, sans-serif;line-height: 24px;font-weight: 500;text-align: right;color:#33312A;text-align:right;">
                                      {{$user->reg_no}}</td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                            <tr>
                              <td height="15" colspan="2"></td>
                            </tr>
                            <tr>
                              <td colspan="3"
                                style="font-size:18px;font-family: Arial, Helvetica, sans-serif;line-height: 24px;font-weight: 500;text-align: center;color:#363636">
                                <font style="font-weight: 600;color: #212121;">Date :</font> {{ $test->created_at->format('d-m-Y') }}
                              </td>
                            </tr>
                          </table>
                        </td>
                        <td width="100"></td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
            <td width="30"></td>
          </tr>
          <tr>
            <td height="110"></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>

</html>
