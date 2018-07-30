<?php
 
 require('AfricasTalkingGateway.php');
 
 require('constants.php');
 
         send_airtime($amount,$phone,$Username,$ApiKey);
         
         mpesa_checkout($amount,$phone,$Username,$ApiKey);
         
        //mpesa_checkout("1600","+254723383299",$Username,$ApiKey);
        
    
         
    function send_airtime($amount,$phone,$Username,$ApiKey){
     
        //Create an instance of our awesome gateway class and pass your credentials
        $gateway = new AfricasTalkingGateway($Username,$ApiKey, "sandbox");
    
        $recipients = array(
            array("phoneNumber"=>$phone, "amount"=>"KES ".$amount."")
        );
        
        $recipientStringFormat = json_encode($recipients);
        
        $message = "You have received Ksh:".$amount." worth of airtime.";
        
        try {
          
                $gateway->sendAirtime($recipientStringFormat);
                
                $gateway->sendMessage($phone, $message);
                    
                return True;
                   
        }
        catch(AfricasTalkingGatewayException $e){
            
          return False;
          
        }
    
    }
    
    function mpesa_checkout($amount,$phone,$Username,$ApiKey){
     
        //Create an instance of our awesome gateway class and pass your credentials
        $gateway = new AfricasTalkingGateway($Username,$ApiKey, "sandbox");
    
        // Specify the name of your Africa's Talking payment product
        $productName  = "SwahilipotHUbCodeChallenge";
        
        // The 3-Letter ISO currency code for the checkout amount
        $currencyCode = "KES";
        
        // Any metadata that you would like to send along with this request
        // This metadata will be  included when we send back the final payment notification
        $metadata  = array(
                            "agentId"   => "1893",
                            "productId" => "Test Product"
                            );
                              
        try {
          
            
                $transactionId = $gateway->initiateMobilePaymentCheckout($productName,
                                   $phone,
                                   $currencyCode,
                                   $amount,
                                   $metadata);
                                   
                //echo "Done sending money";
                $message = "You have approved payment of  Ksh ".$amount." to ".$phone;
                
                $gateway->sendMessage($phone, $message);
                                   
                return True;
                    
        }
        catch(AfricasTalkingGatewayException $e){
            
          return $e;
          
        }
    
    }
    
?>