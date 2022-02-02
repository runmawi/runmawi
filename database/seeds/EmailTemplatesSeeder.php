<?php

use Illuminate\Database\Seeder;
use App\EmailTemplate;
use Carbon\Carbon;

class EmailTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EmailTemplate::truncate();

        $EmailTemplate = [
                        [   'template_type' => 'Welcome Email', 
                            'heading' => 'Welcome to Name',
                            'description' => 'Dear {Name},
                                              Thank you for registering at {Name}. If you have any questions, please reply to this email and one of our team member will reply to you ASAP.
                                              Sincerely,
                                              Team',
                            'role_type' => 'General Email Triggers' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'template_type' => 'Announcements', 
                            'heading' => 'New Announcements',
                            'description' => 'Dear {Name},
                                              Sincerely,
                                              Team {Name}',
                            'role_type' => 'General Email Triggers' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'template_type' => 'Free user', 
                            'heading' => 'You have been granted access to the domain site',
                            'description' => 'Dear {Name},
 
                                             You have been granted access to {Name site}
                                             Please find the following url and credentials.
                                             Url: {Url}
                                             User Name: {UserName}
                                             Password: {Password}
                             
                                             Sincerely,
                                             {Name}',
                            'role_type' => 'General Email Triggers' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'template_type' => 'Forgot password', 
                            'heading' => 'Reset password for your account',
                            'description' =>    'Dear {Name},
                                                 We have received a request to reset your password on {Name}.
                                                 Click on the below link or copy/paste the link in your browser address bar to reset your password.
                                                {link}
                            
                                                 Kindly ignore ',
                            'role_type' => 'General Email Triggers' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'template_type' => 'Announcements', 
                            'heading' => 'NewAnnouncements',
                            'description' => 'n',
                            'role_type' => 'GeneralEmailTriggers' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'template_type' => 'Contact us', 
                            'heading' => '{Name }: Thank you for contacting us',
                            'description' => 'Dear {EndUserName},
                                             Thank you for contacting us. We will get back to you shortly.
                                             Regards,
                                             Name
                                             Your Message
                                            {"originalMessage"}',
                            'role_type' => 'GeneralEmailTriggers' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'template_type' => 'Change Password', 
                            'heading' => 'Password is changed successfully',
                            'description' => 'Dear {Name},
                                              Your profile password has been changed successfully on {Name}.
                             
                                              Sincerely,
                                              Team {Name}',
                            'role_type' => 'GeneralEmailTriggers' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'template_type' => 'Forgot password', 
                            'heading' => 'Reset password for your Studio account',
                            'description' => 'Dear {Name},

                             You are not authenticated to view {VideoName}. Kindly purchase {VideoName} in order to have a seamless viewing experience.
                            
                            Please find below the link to purchase:
                            {ContentLink}',
                            'role_type' => 'GeneralEmailTriggers' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'template_type' => 'Welcome on sub-user registration', 
                            'heading' => 'Welcome to Name',
                            'description' =>    'Dear {Name},
                                                A new account on {Name} has been created for you by your organization admin {ParentName}.
                                                Your login details are as below.
                                                Login ID :{EmailAddress}
                                                Password :{Password}
                                                You can set a',
                            'role_type' => 'GeneralEmailTriggers' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'template_type' => 'Booking Confirmation', 
                            'heading' => 'Booking Confirmation for Name',
                            'description' => 'Dear {Name},
                                            Congratulations. You have successfully registered for the {Session Name}. Please find your session details given below.
                                            Joining Link: {link}
                                            ID: {meeting_id}
                                            Password: {password}
                                            
                                            W',
                            'role_type' => 'GeneralEmailTriggers' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'template_type' => "Welcome on partner's registration", 
                            'heading' => 'Welcome to Name',
                            'description' => 'Dear {Name},
                                            Thank you for registering as a Partner at {Name}. If you have any questions, please reply to this email and one of our team members will reply to you ASAP.
                                            
                                            Sincerely,
                                            Team {Name}
                                            
                                            ',
                            'role_type' => 'GeneralEmailTriggers' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],
                        
                        [   'template_type' => 'Partner Content ApprovalCongratulations! {ContentName} is published Successfully.', 
                            'heading' => 'Congratulations! {ContentName} is published Successfully.',
                            'description' => 'Hi {Name}

                                            Congratulations!
                                            {ContentName} has been published successfully. Please check your content by clicking on the following link.
                                            
                                            Link: {ContentPermalink}
                                            
                                            Regards,
                                            Team {Name}
                                            ',
                            'role_type' => 'GeneralEmailTriggers' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'template_type' => 'Partner Content Reject', 
                            'heading' => 'Sorry! Title {ContentName} could not be published',
                            'description' => "Hi {Name}

                                            Sorry,Title {ContentName} couldn't be published successfully.
                                            Reject Reason: {RejectReason}
                                            
                                            Regards,
                                            Team {Name}
                                            ",
                            'role_type' => 'GeneralEmailTriggers' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'template_type' => 'Partner Content Update', 
                            'heading' => '{ContentName} has been Edited ',
                            'description' => 'Hi {Name}

                                            {ContentName} has been edited.
                                            Please check your content by clicking on the following link.
                                            
                                            Link: {ContentPermalink}
                                            
                                            Regards,
                                            Team {Name}
                                            
                                            ',
                            'role_type' => 'GeneralEmailTriggers' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'template_type' => 'Partner Content Delete', 
                            'heading' => '{ContentName} has been Deleted',
                            'description' => 'Hi {Name}

                                            {Name} has been deleted.
                                            Please contact your store administrator for more information
                                            
                                            
                                            Regards,
                                            Team {Name}
                                            ',
                            'role_type' => 'GeneralEmailTriggers' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'template_type' => 'User mapped to content', 
                            'heading' => 'You have been mapped to a Content',
                            'description' => 'Email subject: You have been mapped to a Content
                                                Dear {Name},
                                                You have been mapped to {ContentName}.
                                                If you are incorrectly mapped with this content, please reach out to us at {EmailAddress}.
                                                
                                                ',
                            'role_type' => 'GeneralEmailTriggers' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'template_type' => 'OTP to email', 
                            'heading' => 'OTP email',
                            'description' => 'Dear {User},
                                            {Otp} is your One time password (OTP) to Login at {Name}.
                                            
                                            
                                            Sincerely,
                                            {Name}
                                            ',
                            'role_type' => 'GeneralEmailTriggers' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],   

                        [   'template_type' => 'Follow User Profile', 
                            'heading' => 'New User Followed !',
                            'description' => 'Dear {Name},

                                            A new user has followed your page. Please refer below details:
                                            Name: {Follow user Name}
                                            Email:  {Follow user Email}
                                            
                                            Sincerely,
                                            Team {Name}',
                            'role_type' => 'GeneralEmailTriggers' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'template_type' => 'Follow Partner Profile', 
                            'heading' => 'New User Followed !',
                            'description' => 'Dear {Name},

                                            A new user has followed your page. Please refer below details:
                                            Name: {Follow user Name}
                                            Email:  {Follow user Email}
                                            
                                            
                                            Sincerely,
                                            Team {Name}
                                            ',
                            'role_type' => 'GeneralEmailTriggers' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],


                        [   'template_type' => 'Registration & purchase subscription', 
                            'heading' => 'Welcome to Name',
                            'description' => 'Dear {Name},

                                            Welcome to {Name}.
                                            
                                            Thank you for registering on {Name} and subscribing to Plan {PlanName}.
                                            Click here to confirm your account and you can start watching our videos anytime.
                                            To vie',
                            'role_type' => 'Subscription' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'template_type' => 'Purchase subscription', 
                            'heading' => 'Name Subscription Activated!',
                            'description' => 'Dear {Name},

                                            Welcome to {Name}.
                                            
                                            Thank you for subscribing to {PlanName}
                                            You can now start watching our videos immediately!
                                            To view your billing history and invoices please click here.
                                            if you ',
                            'role_type' => 'Subscription' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'template_type' => 'Cancel subscription by admin', 
                            'heading' => 'Name Cancellation Confirmation',
                            'description' => 'Dear {Name},

                                              Your account with {Name} has been cancelled by the Administrator. You will no longer have access to our current and future catalog of content. Please email us at {Email} for further in',
                            'role_type' => 'Subscription' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'template_type' => 'Reactive subscription', 
                            'heading' => 'Subscription activated to Name',
                            'description' => 'Dear {Name},

                                                Welcome to {Name}!
                                                
                                                Thank you for re-activating your Subscription to {Name}
                                                
                                                We are happy to see that you have re-activated your {PlanName} subscription to {Name}!
                                                
                                                You can now s',
                            'role_type' => 'Subscription' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'template_type' => 'Recurring billing', 
                            'heading' => null,
                            'description' => 'Dear {Name},
                                            Welcome to {Name}!
                                            Thank you for being part of {Name}
                                            Your {PlanName} subscription to {Name} has been renewed.
                                            Login and continue watching your favorite videos anytime anywhere.
                                            if y',
                            'role_type' => 'Subscription' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'template_type' => 'Failure to pay', 
                            'heading' => 'Subscription - failure to pay',
                            'description' => 'Dear {Name},
                                            This is a reminder of the failure of payment for {Name} subscription.
                                            We have not been able to charge your card {Last4DigitsOfCard}. Please update your card details by {FourDaysAfterSec',
                            'role_type' => 'Subscription' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'template_type' => '2nd reminder for card failure', 
                            'heading' => 'Subscription - 2nd reminder for card failure',
                            'description' => 'Dear {Name},
                                            This is a second and final reminder for the failure of payment for the {Name subscription}.
                                            We have not been able to charge your card {Last4DigitsOfCard}. Please update your card detail',
                            'role_type' => 'Subscription' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'template_type' => 'Cancel subscription by user', 
                            'heading' => 'Name Cancellation Confirmation',
                            'description' => 'Dear {Name},

                                            We acknowledge the receipt of your request to cancel your {PlanName} subscription to {Name}.
                                            
                                            There will not be any further charges on your credit card for the same.You will have acc',
                            'role_type' => 'Subscription' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'template_type' => 'Subscription Expiry Notification', 
                            'heading' => 'Subscription Expiry Notification',
                            'description' => 'Dear {Name},
                                            Your {PlanName} subscription plan will be expired on {EndSubscriptionDate}. Please login to your account to renew the subscription or purchase a new plan..
                                            
                                            Sincerely,
                                            Team {Name}',
                            'role_type' => 'Subscription' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'template_type' => 'Voucher Subscription Cancelled', 
                            'heading' => 'Voucher Subscription Cancelled',
                            'description' => 'Dear {Name},
                                                This email is to notify you that your {Name} voucher subscription has been expired.
                                                Please visit Url anytime when you would like to again purchase subscription. Your profile information',
                            'role_type' => 'Subscription' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'template_type' => 'Authentication is required', 
                            'heading' => 'Your Authentication is required to process the payment',
                            'description' => 'Hi {Name},
                                                Payment to Name failed. Below are the details of the error message.
                                                Name: {Name}
                                                Email: {email}
                                                Company Name: {Name}
                                                Card Number: {Last4DigitsOfCard}
                                                Amount Due: {amount}
                                                Error Messa',
                            'role_type' => 'Subscription' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'template_type' => 'Renewal alert for subscription', 
                            'heading' => 'Your subscription is due for auto renewal on (RenewalDate)',
                            'description' => 'Dear {Name},

                                                We love having you onboard.
                                                We wanted to remind you that your account will be billed for auto renewal of your subscription plan on *RenewalDate.
                                                
                                                Thanks,
                                                Team Name',
                            'role_type' => 'Subscription' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'template_type' => 'Announcements', 
                            'heading' => 'NewAnnouncements',
                            'description' => 'n',
                            'role_type' => 'Subscription' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'template_type' => 'Cancel subscription by partner', 
                            'heading' => 'Name Cancellation Confirmation',
                            'description' => 'Dear {Name},

                                            We acknowledge the receipt of your request to cancel your {PlanName} subscription to {Name}.
                                            
                                            There will not be any further charges on your credit card for the same.
                                            
                                            You can renews',
                            'role_type' => 'Subscription' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'template_type' => 'Failure to pay for Partner', 
                            'heading' => 'Renewal Fail',
                            'description' => 'Dear {Name},
                                            Our attempt to charge your primary credit card on file {CardLastFourDigit} for your {Name} subscription failed.
                                            Please login to {PartnerUrl} and update your card details ASAP to prevent',
                            'role_type' => 'Subscription' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],
                        
                        [   'template_type' => 'Authentication is required for partner', 
                            'heading' => 'Card authentication failed',
                            'description' => 'Dear {Name},
                                              This is to inform you that we are unable to renew your subscription due to card authentication failure. Please log in to your dashboard and authenticate the payment to continue enjoying ',
                            'role_type' => 'Subscription' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],      

                        [   'template_type' => 'Purchase subscription for Partner', 
                            'heading' => 'Name Subscription Activated!',
                            'description' => 'Dear {Name},

                                            We are thrilled to have you on board.
                                            
                                            Thank you for activating your Subscription. Please write to us at {Email} for queries and suggestions.
                                            
                                            Your Admin Panel: {PartnerUrl}
                                            Logi',
                            'role_type' => 'Subscription' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'template_type' => 'Recurring billing for Partner', 
                            'heading' => 'Subscription Successfully Renewed!',
                            'description' => 'Dear {Name},
                                                Thank you for being part of {Name}
                                                Your {PlanName} subscription to {Name} has been renewed. Please find the attached receipt.
                                                If you need further assistance, please contact us at {Emai',
                            'role_type' => 'Subscription' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'template_type' => 'Partner Subscription Cancellation for card failure', 
                            'heading' => 'Subscription - cancellation for card failure',
                            'description' => 'Dear {Name},
                                            This email is to notify you that your {Name subscription} has been cancelled due to payment failure.
                                            Please visit {PartnerUrl} anytime when you would like to renew your subscription.
                                            ',
                            'role_type' => 'Subscription' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'template_type' => 'Pay per view purchase', 
                            'heading' => 'Pay per view purchase',
                            'description' => 'Dear {Name},

                                                Welcome to {Name}.
                                                
                                                Thank you for purchasing Plan {PlanName}.
                                                Click here to confirm your account and you can start watching our videos anytime.
                                                To view your billing history and inv',
                            'role_type' => 'Pay Per View' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'template_type' => 'PPV Content Expired', 
                            'heading' => 'Content Expiry Notification',
                            'description' => 'Dear {Name},
                                            Your {Name plan} will be expired on {EndDate}. Please check your content by clicking on the following link.
                                            
                                            Link: {ContentPermalink}
                                            
                                            Sincerely,
                                            Team {Name}
                                            ',
                            'role_type' => 'Pay Per View' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                    ];

                EmailTemplate::insert($EmailTemplate);

    }
}
