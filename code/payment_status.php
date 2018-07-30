<?php
 $data  = json_decode(file_get_contents('php://input'), true);
 
 require('AfricasTalkingGateway.php');
 
 require('constants.php');
 
        
        //Create an instance of our awesome gateway class and pass your credentials
        $gateway = new AfricasTalkingGateway($Username,$ApiKey, "sandbox");
    
        $category = $data["category"];
    
    if ( $category == "MobileC2B" ) {
       // We have been paid by one of our customers!!
       $phone = $data["source"];
       $value       = $data["value"];
       $account     = $data["clientAccount"];
       
       $message = "You have received ksh: ".$value." from ".$account; 
            
            try {
          
            $gateway->sendMessage($phone, $message);
                    
            }
            catch(AfricasTalkingGatewayException $e){
                
              return False;
              
            }
       
       
       
    } else if ( $category == "MobileB2C" ) {
        
       $phone = $data["source"];
       $value       = $data["value"];
       $account     = $data["clientAccount"];
        
        $message = "You have payed ksh: ".$value." to ".$account;  
            
            try {
          
            $gateway->sendMessage($phone, $message);
                    
            }
            catch(AfricasTalkingGatewayException $e){
                
              return False;
              
            }
        
    } else if ( $category == "MobileCheckout" ) {
        
            $product = $data["productName"];
            $source = $data["source"];
            $phone = $data["source"];
            $amount = $data["value"];
            
            
            $message = "You have Payed ksh: ".$amount." to ".$source." for buying ".$data["requestMetadata"]["productId"]; 
            
            try {
          
            $gateway->sendMessage($phone, $message);
                    
            }
            catch(AfricasTalkingGatewayException $e){
                
              return False;
              
            }
            
            
    } else {
        
        //other
        
    }
 
        
        
    
?>