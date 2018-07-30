<?php
// Reads the variables sent via POST from our gateway
    require('action.php');
    
    //app constants
    require('constants.php');
    
    $sessionId   = $_POST["sessionId"];
    $serviceCode = $_POST["serviceCode"];
    $phoneNumber = $_POST["phoneNumber"];
    
    $text  = $_POST["text"];
    
            switch ($text) {
                
                case "":
                    
                    // This is the first request.
                     $response  = "CON Welcome to Code Challenge SwahiliPot Hub by Johnes\n";
                     $response .= "1. Mobile Checkout \n";
                     $response .= "2. Send Airtime \n";
                     $response .= "3. Quit";
                     
                    break;
                    
                case "1":
                    
                    // Business logic for Mobile Checkout
                      $response = "CON Mobile Checkout \n";
                      $response .= "Enter Amount to pay:";
                      
                    break;
                    
                 case "2":
                    
                   // Business logic for Airtime
                      $response = "CON Airtime Purchase \n";
                      $response .= "Enter Amount to buy:";
                      
                    break;
                    
                case "3":
                    
                   // Business logic for last level
                      $response = "END Thank You for using Code Challenge SwahiliPot Hub";
                      
                    break;
                    
                case $text:
                    
                       if(substr($text, 0, 2) == "1*") {
                           
                          $amt = substr($text,2);
                          
                           if(checkInt($amt)){
                               
                               $result = mpesa_checkout($amt,$phoneNumber,$Username,$ApiKey);
                               
                               
                                 if($result != True){
                                
                                      $response = "END You have payed ksh:".$amt." to ".$phoneNumber." via MPESA Checkout";
                                      
                                  }
                                 else{
                                
                                     $response = "END Payment not sent to ".$phoneNumber." \n Reason: ".$result;
                                  }
                        
                               
                             }else{
                                
                                 $response = "END Invalid Input \n Please use Numbers (0 - 9)"; 
                             }
                           
                           
                       }
                       
                       else if(substr($text, 0, 2) == "2*"){
                           
                              $amt = substr($text,2);
                              
                              if(checkInt($amt)){
                                
                                    if(send_airtime($amt,$phoneNumber,$Username,$ApiKey)){
                                
                                      $response = "END You have bought Ksh:".$amt." worth of Airtime to ".$phoneNumber;
                                      
                                    }
                                 else{
                                
                                     $response = "END Failed Buying Airtime to ".$phoneNumber;
                                  }
                                
                            }else{
                                
                                $response = "END Invalid Input Airtime \n Please use Numbers (0 - 9)";
                            }
                           
                       }
                    
                     
                    break;
                    
                
                default:
                    
                    $response = "END Invalid Input Menu \n Please select Numbers (1, 2 or 3)";
            }
            
             
            
        // Print the response onto the page so that our gateway can read it
        header('Content-type: text/plain');
        echo $response;
        // DONE!!!
        
    //check if the provided character is an integer
    function checkInt($number){
        
        if (filter_var($number, FILTER_VALIDATE_INT) === 0 || filter_var($number, FILTER_VALIDATE_INT)) {
                
                return True;
            } else {
                
                return False;
            } 
    }
    
    
?>
