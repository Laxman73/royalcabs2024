<html>
    <head>
    	<style>
           body {
           }


           .search_area_textfeild_mendatory_field {
                margin:0;
                padding:11px 0 0 0;
                width:100px;
                height:auto;
                float:none;
                font-family:Arial, Helvetica, sans-serif;
                color:#333333;
                font-size:12px;
                font-weight:bold;
            }


            .light_success_vm{
                margin:0;
                padding:5px 5px;
                width:500px;
                height: 20px;
                float:left;
                background:#F79237;
                font-family:Arial, Helvetica, sans-serif;
                font-size: 12px;
                color:#ffffff;
                font-weight:bold;

            }
            .light_error_vm{
                margin:0;
                padding:5px 5px;
                width:500px;
                height: 20px;
                float:left;
                background:#0662B0;
                font-family:Arial, Helvetica, sans-serif;
                font-size: 12px;
                color:#ffffff;
                font-weight:bold;

            }

            .button_all_in {
                margin:0;
                width:99px;
                float:left;
                background: url(images/small_button.png) no-repeat;
                color: #FFFFFF;
                cursor: pointer;
                font-size: 13px;
                font-weight: bold;
                line-height: 1.2857;
                padding: 5px 0 5px 0;
                text-align: center;
                vertical-align: middle;
                font-family:Arial, Helvetica, sans-serif;
            }

            .header_logo {
                margin:12px 0 12px 0;
                padding:0;
                width:209px;
                height:auto;
                float:left;
            }

            .merchant_area_name1 {
               margin:0;
               padding:6px 0 6px 0;
               width:100px;
               height:auto;
               float:left;
               font-family:Arial, Helvetica, sans-serif;
               font-size: 12px;
               color:#0866c6;
           }

           .merchant_area_nameHeader {
               font-family:Arial, Helvetica, sans-serif;
               font-size: 20px;
               color:#0866c6;
               font-weight: bold;
           }
        </style>
    </head>

<body>

  <? php
		//include 'CSS1_Index.css';

  ?>

        <form name ="pine" action="Purchase_Redirect.php"  id="pine" method="POST">
            <div>
                <div id="TopDiv">
                    <div>
                        <h1 style="text-align: center ;color:#333">Test Purchase Transaction</h1>

                        <div style="text-align: center">
                            <table id="Table1" style="border-color:activeborder;padding-left: 400px">
                                <tbody>
                                    <tr>
                                        <td colspan="2"><span id="MerchantMessage" class="light_success_vm"></span>
                                            <br>
                                            <br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span id="LBLAmunt" class="search_area_textfeild_mendatory_field">Amount (in paisa):</span></td><td><input name="ppc_Amount" type="text"   maxlength="8" id="Amount" class="merchant_area_name1" style="width:150px;" required></td>
                                    </tr>
                                    <tr>
                                        <td><span id="Label1" class="search_area_textfeild_mendatory_field">Merchant ID:</span></td><td><input name="ppc_MerchantID" type="text" maxlength="10" value="15360" id="MerchantID" class="merchant_area_name1" style="width:150px;" required></td>
                                    </tr>
                                    <tr>
                                        <td><span id="LabelUniqueMerchantId" class="search_area_textfeild_mendatory_field">Unique Merchant Txn ID:</span></td><td><input name="ppc_UniqueMerchantTxnID" type="text" maxlength="99" class ="merchant_area_name1" id="UniqueMerchantTxnID"  style="width:150px;" required></td>
                                    </tr>
                                    <tr>
                                        <td><span id="LabelMerchantAuthToken" class="search_area_textfeild_mendatory_field">Merchant Access Code:</span></td><td><input name="ppc_MerchantAccessCode" type="password" maxlength="49" id="MerchantAuthCode" class="merchant_area_name1" style="width:150px;" required></td>
                                    </tr>
                                    <tr>
                                        <td><span id="LabelPCode" class="search_area_textfeild_mendatory_field">Product Code:</span></td><td><input name="ppc_Product_Code" type="text" maxlength="49" id="ProductCode" class="merchant_area_name1" style="width:150px;"></td>
                                    </tr>
                                    <tr >
                                        <td><span id="LabelPMode" class="search_area_textfeild_mendatory_field">Pay Mode:</span></td><td><input name="ppc_PayModeOnLandingPage" value="1,4" type="text" maxlength="49" id="PayMode" class="merchant_area_name1" style="width:150px;"></td>
                                    </tr>
                                    <tr>
                                        <td><span id="LabelCustomerMobile" class="search_area_textfeild_mendatory_field">Customer Mobile:</span></td><td><input name="ppc_CustomerMobile" type="text" maxlength="99" class ="merchant_area_name1" id="CustomerMobile"  style="width:150px;" required></td>
                                    </tr>
                                    <tr>
                                        <td><span id="LabelCustomerEmail" class="search_area_textfeild_mendatory_field">Customer Email:</span></td><td><input name="ppc_CustomerEmail" type="text" maxlength="99" class ="merchant_area_name1" id="CustomerEmail"  style="width:150px;" required></td>
                                    </tr>
        <!-- 	<tr>
                <td><span id="LabelSeqId" class="search_area_textfeild_mendatory_field">Sequence Id</span></td><td><select name="ppc_LPC_SEQ" id="MerchantSeqId" class="merchant_area_name1" style="width:150px;">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>

                </select></td>
            </tr> -->
                                    <tr>
                                        <td colspan="2" style="text-align:center;float:right;"><p style="text-align: center;color: blue;margin: 25px 115px 5px 150px"> <input type="submit" value="Submit" ></p></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><span id="LabelFooter" class="light_error_vm"></span>
                                            <br>
                                            <br>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table id="TblCaptureResponse" style="border-color:activeborder;padding-left: 400px; display: none">
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>
