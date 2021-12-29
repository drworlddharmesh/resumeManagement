<!DOCTYPE html>
<html>
<head>
	<title>Table</title>
</head>
<body style="padding: 10px 20px">

	<h2 style="text-align: center;">INVOICE</h2>

	<table border="1px solid" width="100%" style="border-collapse: collapse">
		<tr>
            <td rowspan="3" colspan="6">
                <br>
                SEARCH JOBS FOR YOU (DL1) <br>
                225, FOUR POINT, Vip Road,<br>
                Surat 395007.<br>
                GSTIN NO-24BGTPD3963P1ZP <br>
                HSN/SAC - 9983
                <br>
                E-Mail : info@searchjobsforyou.com
            </td>

            <td colspan="3">
                Invoice No. <br>
                <b>{{$Invoice}}</b> <br>
            </td>

            <td colspan="3">
                Dated <br>
                <b>{{$Current_date}}</b> <br>
            </td>
        </tr>

        <tr>
            <td colspan="3">
                Delivery Note <br>
            </td>

            <td colspan="3">
                Mode/Terms of Payment <br>
            </td>
        </tr>

        <tr>
            <td colspan="3">
                Supplier’s Ref. <br>
            </td>

            <td colspan="3" style="padding: 4px;">
                Other Reference(s) <br>
            </td>
        </tr>

        <tr>
            <td rowspan="4" colspan="6" style="vertical-align: top;">
                Buyer <br>
                <b>{{$UserName}}</b>
            </td>

            <td colspan="3">
                Buyer’s Order No. <br>
            </td>

            <td colspan="3">
                Dated <br>
            </td>
        </tr>

        <tr>
            <td colspan="3">
                Despatch Document No. <br>
            </td>

            <td colspan="3">
                Delivery Note Date <br>
            </td>
        </tr>

        <tr>
            <td colspan="3">
                Despatched through <br>
            </td>

            <td colspan="3">
                Destination <br>
            </td>
        </tr>

        <tr>
            <td colspan="6">
                Terms of Delivery <br>
                <br>
                <br>
            </td>
        </tr>

        <tr>
            <th><b>SI No.</b></th>
            <th colspan="5"><b>Description of Goods</b></th>
            <th colspan="2"><b>Quantity</b></th>
            <th><b>Rate</b></th>
            <th><b>per</b></th>
            <th colspan="2"><b>Amount</b></th>
        </tr>

        <tr>
            <td style="text-align: center;"><p style="margin: unset;"><b>1</b></p></td>
            <td colspan="5" style="padding: 4px;"><p style="margin: unset;"><b>PORTAL SERVICE CHARGES</b></p></td>
            <td colspan="2" style="padding: 4px;"></td>
            <td style="padding: 4px;"></td>
            <td style="padding: 4px;"></td>
            <td colspan="2" style="text-align: right; padding: 4px;"><p style="margin: unset;"><b>5000.00</b></p></td>
        </tr>

        <tr style="border-top: unset; border-bottom: unset;">
            <td style="padding: 4px;"><br></td>
            <td colspan="5" style="padding: 4px;"><br></td>
            <td colspan="2" style="padding: 4px;"><br></td>
            <td style="padding: 4px;"><br></td>
            <td style="padding: 4px;"><br></td>
            <td colspan="2" style="padding: 4px;"><br></td>
        </tr>

        <tr style="border-top: unset; border-bottom: unset;">
            <td style="padding: 4px;"><br></td>
            <td colspan="5" style="text-align: right; padding: 4px;"><p style="margin: unset;"><b>IGST</b></p></td>
            <td colspan="2" style="padding: 4px;"><br></td>
            <td style="text-align: right; padding: 4px;"><p style="margin: unset;"><b>18</b></p></td>
            <td style="text-align: center; padding: 4px;"><p style="margin: unset;"><b>%</b></p></td>
            <td colspan="2" style="text-align: right; padding: 4px;"><p style="margin: unset;"><b>900.00</b></p></td>
        </tr>

        <tr style="border-top: unset; border-bottom: unset;">
            <td style="padding: 4px;"><br></td>
            <td colspan="5" style="padding: 4px;"><br></td>
            <td colspan="2" style="padding: 4px;"><br></td>
            <td style="padding: 4px;"><br></td>
            <td style="padding: 4px;"><br></td>
            <td colspan="2" style="padding: 4px;"><br></td>
        </tr>

        <tr style="border-top: unset; border-bottom: unset;">
            <td style="padding: 4px;"><br></td>
            <td colspan="5" style="padding: 4px;"><br></td>
            <td colspan="2" style="padding: 4px;"><br></td>
            <td style="padding: 4px;"><br></td>
            <td style="padding: 4px;"><br></td>
            <td colspan="2" style="padding: 4px;"><br></td>
        </tr>

        <tr style="border-top: unset; border-bottom: unset;">
            <td style="padding: 4px;"><br></td>
            <td colspan="5" style="padding: 4px;"><br></td>
            <td colspan="2" style="padding: 4px;"><br></td>
            <td style="padding: 4px;"><br></td>
            <td style="padding: 4px;"><br></td>
            <td colspan="2" style="padding: 4px;"><br></td>
        </tr>

        <tr style="border-top: unset;">
            <td style="padding: 4px;"><br></td>
            <td colspan="5" style="padding: 4px;"><br></td>
            <td colspan="2" style="padding: 4px;"><br></td>
            <td style="padding: 4px;"><br></td>
            <td style="padding: 4px;"><br></td>
            <td colspan="2" style="padding: 4px;"><br></td>
        </tr>

        <tr>
            <td style="padding: 4px;"></td>
            <td colspan="5" style="text-align: right; padding: 4px;"><p style="margin: unset;">Total</p></td>
            <td colspan="2" style="padding: 4px;"></td>
            <td style="padding: 4px;"></td>
            <td style="padding: 4px;"></td>
            <td colspan="2" style="text-align: center; padding: 4px;"><p style="margin: unset;"><b>Rs. 5900.00</b></p></td>
        </tr>

        <tr style="border: unset;">
            <td colspan="6" style="padding: 4px;"><p style="margin: unset;">Amount Chargeable (in words)</p></td>
            <td colspan="6" style="text-align: right; padding: 4px;"><p style="margin: unset;">E. & O.E</p></td>
        </tr>

        <tr style="border: unset;">
            <td colspan="12" style="padding: 4px;"><p style="margin: unset;"><b>INR Five Thousand Nine Hundred Only</b></p></td>
        </tr>

        <tr>
            <td colspan="12" style="padding: 4px;">
                <p><br></p>
                <p><br></p>
            </td>
        </tr>

        <tr>
            <td colspan="8">
                <u>Declaration</u> <br>
                We declare that this invoice shows the actual price of <br>
                described and that all particulars are true <br>
                and correct.
            </td>

            <td colspan="4" style="text-align: right;">
                <b>for SEARCH JOBS FOR YOU (DL1)</b> <br>
                <br>
                <br>
                Authorised Signatory
            </td>
        </tr>
	</table>

</body>
</html>