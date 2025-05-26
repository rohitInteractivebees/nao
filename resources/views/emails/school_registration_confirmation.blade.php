<table cellspacing='0' cellpadding='0' width='700px' align='center' bgcolor='#F1F7FF'>
    <tr>
        <td height='20px'></td>
    </tr>
    <tr>
        <td align='center'><img src="{{url('images/logo.jpg') }}" width='157'></td>
    </tr>
    <tr>
        <td height='20px'></td>
    </tr>
    <tr>
        <td>
            <table cellspacing='0' cellpadding='0' width='100%' align='center'>
                <tr>
                    <td width='40'></td>
                    <td>
                        <table cellspacing='0' cellpadding='0' width='100%' align='center' bgcolor='#fff' style='border-top: 4px solid #d92635;'>
                            <tr>
                                <td height='20px'></td>
                            </tr>
                            <tr>
                                <td align='center' style='font-size: 18px;font-family:Arial, Helvetica, sans-serif;font-weight: 600;color:#193296;'>Welcome to National Automobile Olympiad (NAO) 2025 – School Registration Successful</td>
                            </tr>
                            <tr>
                                <td height='40px'></td>
                            </tr>
                            <tr>
                                <td>
                                    <table cellspacing='0' cellpadding='0' width='100%'>
                                        <tr>
                                            <td width='20'></td>
                                            <td>
                                                <table cellspacing='0' cellpadding='0' width='100%'>
                                                    <tr>
                                                        <td style='font-size: 14px;font-family:Arial, Helvetica, sans-serif;font-weight: 500;color: #2E2E2E;'>Dear {{ $name }},   </td>
                                                    </tr>
                                                    <tr>
                                                        <td height='15px'></td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td style='font-size: 14px;font-family:Arial, Helvetica, sans-serif;font-weight: 500;color: #2E2E2E;'>We are delighted to welcome your esteemed institution to the <b>National Automobile Olympiad (NAO)</b> 2025 – a flagship initiative by <b>Automotive Skills Development Council (ASDC)</b> in collaboration with Central Board of Secondary Education (CBSE), aimed at empowering students with future-ready skills in the dynamic world of mobility and technology. </td>
                                                    </tr>
                                                    <tr>
                                                        <td height='15px'></td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td style='font-size: 14px;font-family:Arial, Helvetica, sans-serif;font-weight: 500;color: #2E2E2E;'>Your school is now officially registered to participate in NAO. </td>
                                                    </tr>
                                                    <tr>
                                                        <td height='15px'></td>
                                                    </tr>
                                                     <tr>
                                                        <td style='font-size: 14px;font-family:Arial, Helvetica, sans-serif;font-weight: 500;color: #2E2E2E;'>Here are your school login credentials:</td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td height='10px'></td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-size:14px; font-family:Arial,Helvetica,sans-serif; font-weight:600; color:#2E2E2E'><b>User Id:</b> <span style="color: #193296">{{ $loginId }}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td height='10px'></td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-size:14px; font-family:Arial,Helvetica,sans-serif; font-weight:600; color:#2E2E2E'><b>Password:</b> <span style="color: #193296">{{ $pass }}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td height='10px'></td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-size:14px; font-family:Arial,Helvetica,sans-serif; font-weight:600; color:#2E2E2E'>Download sample paper : <a href="{{ url('sampleCsv/Olympiad_Questionnaire_Group1.pdf') }}" download target="_blank">Group-1</a>, <a href="{{ url('sampleCsv/Olympiad_Questionnaire_Group2.pdf') }}" download target="_blank">Group-2</a>, <a href="{{ url('sampleCsv/Olympiad_Questionnaire_Group3.pdf') }}" download target="_blank">Group-3</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td height='15px'></td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-size:14px; font-family:Arial,Helvetica,sans-serif; font-weight:500; color:#2E2E2E'>Access your school dashboard here:</td>
                                                    </tr>
                                                     <tr>
                                                        <td height='10px'></td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-size:14px; font-family:Arial,Helvetica,sans-serif; font-weight:600; color:#2E2E2E'>👉 <a href="{{ url('/login') }}" style="color: #193296;">School Login Link</a> </td>
                                                    </tr>
                                                    <tr>
                                                        <td height='15px'></td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-size:14px; font-family:Arial,Helvetica,sans-serif; font-weight:500; color:#2E2E2E'>If you opt for online registration of your students, you may provide the following <b>Online Registration Link</b> to your students for their registration: </td>
                                                    </tr>
                                                     <tr>
                                                        <td height='10px'></td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-size:14px; font-family:Arial,Helvetica,sans-serif; font-weight:600; color:#2E2E2E'>👉 <a href="{{ url('register/' . $code) }}" style="color: #193296;">Student Registration Link</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td height='15px'></td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-size: 14px;font-family:Arial, Helvetica, sans-serif;font-weight: 500;color: #444;line-height: 22px;'>🏁 <em>“NAO empowers schools to equip students with future-ready automotive and technological skills, laying the foundation for careers that will drive tomorrow’s world.” </em></td>
                                                    </tr>
                                                    <tr>
                                                        <td height='15px'></td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-size: 14px;font-family:Arial, Helvetica, sans-serif;font-weight: 500;color: #444;line-height: 22px;'>Through NAO, your students will explore cutting-edge domains like <b>automotive engineering, robotics, AI, 3D printing, mechatronics, and sustainable mobility,</b> gaining exposure beyond textbooks. </td>
                                                    </tr>
                                                    <tr>
                                                        <td height='15px'></td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-size: 14px;font-family:Arial, Helvetica, sans-serif;font-weight: 500;color: #444;line-height: 22px;'>We’re excited to partner with your school in shaping the innovators of tomorrow. Should you require any support, our team is always here to assist. For any queries contact<a href="mailto:nep@asdc.org.in"> nep@asdc.org.in</a> </td>
                                                    </tr>
                                                    <tr>
                                                        <td height='20px'></td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-size:14px; font-family:Arial,Helvetica,sans-serif; font-weight:500; color:#2E2E2E;'>Warm regards,</td>
                                                    </tr>
                                                    <tr>
                                                        <td height='5px'></td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-size:14px; font-family:Arial,Helvetica,sans-serif; font-weight:500; color:#2E2E2E;'><b>NAO Team</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td height='5px'></td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-size:14px; font-family:Arial,Helvetica,sans-serif; font-weight:500; color:#2E2E2E;'>[National Automobile Olympiad]</td>
                                                    </tr>
                                                    <tr>
                                                        <td height='20px'></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td width='20'></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td height='20px'></td>
                            </tr>
                        </table>
                    </td>
                    <td width='40'></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td height='30px'></td>
    </tr>
</table>