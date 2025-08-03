<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8" />
  <title>OTP Code</title>
</head>
<body style="margin:0; padding:0; background-color:#f5f7fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

  <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#f5f7fa; padding: 40px 0;">
    <tr>
      <td align="center">

        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="400" style="background:#f1f5ff; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); padding: 30px;">
          <tr>
            <td align="center" style="padding-bottom: 20px;">
              <h1 style="color:#002766; margin:0; font-size: 28px;">OTP Code</h1>
            </td>
          </tr>
          <tr>
            <td style="color:#333; font-size: 16px; line-height: 1.5; padding-bottom: 20px; text-align:center;">
              Hello {{ $firstName }},<br />
              <br />
              Use the one-time password (OTP) below to complete your registration. This code will expire in 10 minutes.
            </td>
          </tr>
          <tr>
            <td align="center" style="padding-bottom: 30px;">
              <div style="display: inline-block; background-color: #002766; color: #fff; font-weight: 700; font-size: 32px; letter-spacing: 0.3rem; padding: 15px 40px; border-radius: 6px; user-select: none;">
                {{ $otp }}
              </div>
            </td>
          </tr>
          <tr>
            <td style="color:#666; font-size: 14px; line-height: 1.4; text-align:center;">
              If you did not request this code, please ignore this email.<br />
              Thank you!
            </td>
          </tr>
          <tr>
            <td align="center" style="padding-top: 30px; font-size: 12px; color: #002766; font-weight: bold;">
              &copy; {{ date('Y') }} Rex MFB
            </td>
          </tr>
        </table>

      </td>
    </tr>
  </table>

</body>
</html>
