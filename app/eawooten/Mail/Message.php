<?php namespace eawooten\Mail;

class Message
{
	protected $mailer;

	public function __construct($mailer)
	{
		$this->mailer = $mailer;
	}

	public function to($address)
	{
		// Defining who to send email to using PHPMailer
		$this->mailer->addAddress($address);
	}

	public function subject($subject)
	{
		// Defining what the subject property of the email will be
		$this->mailer->Subject = $subject;
	}

	public function body($body)
	{
		// Used for construction in the Send method
		$this->mailer->Body = $body;
	}
}

 ?>