<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_checkout = $row['banner_checkout'];
}
?>

<?php
if(!isset($_SESSION['cart_p_id'])) {
    header('location: cart.php');
    exit;
}
?>

<div class="page-banner" style="background-image: url(assets/uploads/<?php echo $banner_checkout; ?>)">
    <div class="overlay"></div>
    <div class="page-banner-inner">
        <h1><?php echo LANG_VALUE_22; ?></h1>
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                
                <?php if(!isset($_SESSION['customer'])): ?>
                    <p>
                        <a href="login.php" class="btn btn-md btn-danger"><?php echo LANG_VALUE_160; ?></a>
                    </p>
                <?php else: ?>

                <h3 class="special"><?php echo LANG_VALUE_26; ?></h3>
                <div class="cart">
                    <table class="table table-responsive table-hover table-bordered">
                        <tr>
                            <th><?php echo '#' ?></th>
                            <th><?php echo LANG_VALUE_8; ?></th>
                            <th><?php echo LANG_VALUE_47; ?></th>
                            <th><?php echo LANG_VALUE_157; ?></th>
                            <th><?php echo LANG_VALUE_158; ?></th>
                            <th><?php echo LANG_VALUE_159; ?></th>
                            <th><?php echo LANG_VALUE_55; ?></th>
                            <th class="text-right"><?php echo LANG_VALUE_82; ?></th>
                        </tr>
                         <?php
                        $table_total_price = 0;

                        $i=0;
                        foreach($_SESSION['cart_p_id'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_id[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_size_id'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_size_id[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_size_name'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_size_name[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_color_id'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_color_id[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_color_name'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_color_name[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_p_qty'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_qty[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_p_current_price'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_current_price[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_p_name'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_name[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_p_featured_photo'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_featured_photo[$i] = $value;
                        }
                        ?>
                        <?php for($i=1;$i<=count($arr_cart_p_id);$i++): ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td>
                                <img src="assets/uploads/<?php echo $arr_cart_p_featured_photo[$i]; ?>" alt="">
                            </td>
                            <td><?php echo $arr_cart_p_name[$i]; ?></td>
                            <td><?php echo $arr_cart_size_name[$i]; ?></td>
                            <td><?php echo $arr_cart_color_name[$i]; ?></td>
                            <td><?php echo number_format($arr_cart_p_current_price[$i]); ?> <?php echo LANG_VALUE_1; ?></td>
                            <td><?php echo $arr_cart_p_qty[$i]; ?></td>
                            <td class="text-right">
                                <?php
                                $row_total_price = $arr_cart_p_current_price[$i]*$arr_cart_p_qty[$i];
                                $table_total_price = $table_total_price + $row_total_price;
                                ?>
                                <?php echo number_format($row_total_price); ?> <?php echo LANG_VALUE_1; ?>
                            </td>
                        </tr>
                        <?php endfor; ?>           
                        <tr>
                            <th colspan="7" class="total-text"><?php echo LANG_VALUE_81; ?></th>
                            <th class="total-amount"><?php echo number_format($table_total_price); ?> <?php echo LANG_VALUE_1; ?></th>
                        </tr>
                        <?php
                        $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost WHERE country_id=?");
                        $statement->execute(array($_SESSION['customer']['cust_country']));
                        $total = $statement->rowCount();
                        if($total) {
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                $shipping_cost = $row['amount'];
                            }
                        } else {
                            $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost_all WHERE sca_id=1");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                $shipping_cost = $row['amount'];
                            }
                        }                        
                        ?>
                        <tr>
                            <td colspan="7" class="total-text"><?php echo LANG_VALUE_84; ?></td>
                            <td class="total-amount"><?php echo number_format($shipping_cost); ?> <?php echo LANG_VALUE_1; ?></td>
                        </tr>
                        <tr>
                            <th colspan="7" class="total-text"><?php echo LANG_VALUE_82; ?></th>
                            <th class="total-amount">
                                <?php
                                $final_total = $table_total_price+$shipping_cost;
                                ?>
                                
                                <?php echo number_format($final_total); ?> <?php echo LANG_VALUE_1; ?>
                                
                                
                            </th>
                        </tr>
                    </table> 
                </div>

                

                <div class="billing-address">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="special"><?php echo LANG_VALUE_161; ?></h3>
                            <table class="table table-responsive table-bordered table-hover table-striped bill-address">
                                <tr>
                                    <td><?php echo LANG_VALUE_102; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_b_name']; ?></p></td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_103; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_b_cname']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_104; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_b_phone']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_106; ?></td>
                                    <td>
                                        <?php
                                        $statement = $pdo->prepare("SELECT * FROM tbl_country WHERE country_id=?");
                                        $statement->execute(array($_SESSION['customer']['cust_b_country']));
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            echo $row['country_name'];
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_105; ?></td>
                                    <td>
                                        <?php echo nl2br($_SESSION['customer']['cust_b_address']); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_107; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_b_city']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_108; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_b_state']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_109; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_b_zip']; ?></td>
                                </tr>                                
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h3 class="special"><?php echo LANG_VALUE_162; ?></h3>
                            <table class="table table-responsive table-bordered table-hover table-striped bill-address">
                                <tr>
                                    <td><?php echo LANG_VALUE_102; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_s_name']; ?></p></td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_103; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_s_cname']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_104; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_s_phone']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_106; ?></td>
                                    <td>
                                        <?php
                                        $statement = $pdo->prepare("SELECT * FROM tbl_country WHERE country_id=?");
                                        $statement->execute(array($_SESSION['customer']['cust_s_country']));
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            echo $row['country_name'];
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_105; ?></td>
                                    <td>
                                        <?php echo nl2br($_SESSION['customer']['cust_s_address']); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_107; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_s_city']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_108; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_s_state']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_109; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_s_zip']; ?></td>
                                </tr> 
                            </table>
                        </div>
                    </div>                    
                </div>

                

                <div class="cart-buttons">
                    <ul>
                        <li><a href="cart.php" class="btn btn-primary"><?php echo LANG_VALUE_21; ?></a></li>
                    </ul>
                </div>

				<div class="clear"></div>
                <h3 class="special"><?php echo LANG_VALUE_33; ?></h3>
                <div class="row">
                    
                    	<?php
		                $checkout_access = 1;
		                if(
		                  //  ($_SESSION['customer']['cust_b_name']=='') ||
		                  //  ($_SESSION['customer']['cust_b_cname']=='') ||
		                  //  ($_SESSION['customer']['cust_b_phone']=='') ||
		                  //  ($_SESSION['customer']['cust_b_country']=='') ||
		                  //  ($_SESSION['customer']['cust_b_address']=='') ||
		                  //  ($_SESSION['customer']['cust_b_city']=='') ||
		                  //  ($_SESSION['customer']['cust_b_state']=='') ||
		                  //  ($_SESSION['customer']['cust_b_zip']=='') ||
		                    ($_SESSION['customer']['cust_s_name']=='') ||
		                    ($_SESSION['customer']['cust_s_cname']=='') ||
		                    ($_SESSION['customer']['cust_s_phone']=='') ||
		                    ($_SESSION['customer']['cust_s_country']=='') ||
		                    ($_SESSION['customer']['cust_s_address']=='') ||
		                    ($_SESSION['customer']['cust_s_city']=='') ||
		                    ($_SESSION['customer']['cust_s_state']=='') ||
		                    ($_SESSION['customer']['cust_s_zip']=='')
		                ) {
		                    $checkout_access = 0;
		                }
		                ?>
		                <?php if($checkout_access == 0): ?>
		                	<div class="col-md-12">
				                <div style="color:red;font-size:22px;margin-bottom:50px;">
                                Chưa có địa chỉ giao hàng. Quý khách vui lòng cập nhật địa chỉ giao hàng tại <a href="customer-billing-shipping-update.php" style="color:red;text-decoration:underline;">đây</a>.
			                    </div>
	                    	</div>
	                	<?php else: ?>
		                	<div class="col-md-4">
		                		
	                            <div class="row">

	                                <div class="col-md-12 form-group">
	                                    <label for=""><?php echo LANG_VALUE_34; ?> *</label>
	                                    <select name="payment_method" class="form-control select2" id="advFieldsStatus">
	                                        <option value=""><?php echo LANG_VALUE_35; ?></option>
	                                        <option value="PayPal"><?php echo LANG_VALUE_36; ?></option>
	                                        <option value="Tien-mat">Thanh toán khi nhận hàng</option>
                                            <!--<option value="pay">Pay</option>-->
	                                    </select>
	                                </div>

                                    <form class="paypal" action="<?php echo BASE_URL; ?>payment/paypal/payment_process.php" method="post" id="paypal_form" target="_blank">
                                        
                                        <input type="hidden" name="cmd" value="_xclick" />
                                        <input type="hidden" name="no_note" value="1" />
                                        <input type="hidden" name="lc" value="UK" />
                                        <input type="hidden" name="currency_code" value="USD" />
                                        <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />

                                        <input type="hidden" name="final_total" value="<?php echo $final_total; ?>">
                                        <div class="col-md-12 form-group">
                                            <input type="submit" class="btn btn-primary" value="<?php echo LANG_VALUE_46; ?>" name="form1">
                                            <!-- Start Paypal -->
                                            <input type="hidden" name="amount" value="<?php echo $final_total; ?>" id="final_total" action="<?php echo BASE_URL; ?>payment/paypal/payment_process.php">
                                    <div id="paypal-button-container"></div>
                                    <script src="https://www.paypal.com/sdk/js?client-id=ASSTr0crFk43ozieoaLv5Ll4-AxRB1rhFzh6TmbUl3Qv03q59EuHYeGkfxWFOSSm5EFRiAsZ5DchM-xL&currency=USD"></script>
                                    <script>
                                        paypal.Buttons({
                                            // Sets up the transaction when a payment button is clicked
                                            createOrder: (data, actions) => {
                                                var final_total = document.getElementById('final_total').value;
                                            return actions.order.create({
                                                purchase_units: [{
                                                amount: {
                                                    value: final_total/25000 // Can also reference a variable or function
                                                }
                                                }]
                                            });
                                            },
                                            // Finalize the transaction after payer approval
                                            onApprove: (data, actions) => {
                                            return actions.order.capture().then(function(orderData) {
                                                // Successful capture! For dev/demo purposes:
                                                console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                                                const transaction = orderData.purchase_units[0].payments.captures[0];
                                                alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);
                                                window.location.replace('http://localhost/shopdienthoai/payment_success.php')
                                                // When ready to go live, remove the alert and show a success message within this page. For example:
                                                // const element = document.getElementById('paypal-button-container');
                                                // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                                                // Or go to another URL:  actions.redirect('thank_you.html');
                                            });
                                            }
                                             }).render('#paypal-button-container');
                                        </script>
                                        <!-- End Paypal -->
                                        </div>
                                    </form>
                                    <div>
                                    <!-- <form class="btn-momo" method="POST" target="_blank" enctype="application/x-www-form-urlencoded"
                          action="payment/momo/xulythanhtoanmomo.php" value="<?php echo $final_total; ?>"> 
                                        <input type = "submit" name ="momo" value = "Thanh toán MOMO QRcode" class ="btn btn-danger">
                                    </form>

                                    <form class="btn-momo" method= "POST" target="_blank" enctype="application/x-www-form-urlencoded" action="payment/momo/xulythanhtoanmomo-atm.php">
                                        <input type="submit" name= "momo" value="Thanh toán MOMO ATM" class="btn btn-danger">
                                    </form>
                                    </div> -->

                                    <form action="payment/bank/init.php" method="post" id="bank_form">
                                        <input type="hidden" name="amount" value="<?php echo $final_total; ?>">
                                        <div class="col-md-12 form-group">
                                            <label style="color:red;" for=""><?php echo LANG_VALUE_43; ?></span></label><br>
                                            <?php
                                            $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
                                            $statement->execute();
                                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($result as $row) {
                                                echo nl2br($row['bank_detail']);
                                            }
                                            ?>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label for=""><?php echo LANG_VALUE_44; ?> <br><span style="font-size:12px;font-weight:normal;">(<?php echo LANG_VALUE_45; ?>)</span></label>
                                            <textarea name="transaction_info" class="form-control" cols="30" rows="10"></textarea>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <input type="submit" class="btn btn-primary" value="<?php echo LANG_VALUE_46; ?>" name="form3">
                                        </div>
                                    </form>
                                    
                           

	                                <!-- <input type="hidden" name="amount" value="<?php echo $final_total; ?>" id="final_total" action="<?php echo BASE_URL; ?>payment/paypal/payment_process.php">
                                    <div id="paypal-button-container"></div>
                                    <script src="https://www.paypal.com/sdk/js?client-id=ASSTr0crFk43ozieoaLv5Ll4-AxRB1rhFzh6TmbUl3Qv03q59EuHYeGkfxWFOSSm5EFRiAsZ5DchM-xL&currency=USD"></script>
                                    <script>
                                        paypal.Buttons({
                                            // Sets up the transaction when a payment button is clicked
                                            createOrder: (data, actions) => {
                                                var final_total = document.getElementById('final_total').value;
                                            return actions.order.create({
                                                purchase_units: [{
                                                amount: {
                                                    value: final_total/24830 // Can also reference a variable or function
                                                }
                                                }]
                                            });
                                            },
                                            // Finalize the transaction after payer approval
                                            onApprove: (data, actions) => {
                                            return actions.order.capture().then(function(orderData) {
                                                // Successful capture! For dev/demo purposes:
                                                console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                                                const transaction = orderData.purchase_units[0].payments.captures[0];
                                                alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);
                                                window.location.replace('http://localhost:8080/ecommerceweb/payment_success.php')
                                                // When ready to go live, remove the alert and show a success message within this page. For example:
                                                // const element = document.getElementById('paypal-button-container');
                                                // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                                                // Or go to another URL:  actions.redirect('thank_you.html');
                                            });
                                            }
                                             }).render('#paypal-button-container');
                                        </script> -->
	                            </div>
		                            
		                        
		                    </div>
		                <?php endif; ?>
                        
                </div>
                

                <?php endif; ?>

            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>