<?php

namespace App\Helpers;

use EmailReplyParser\EmailReplyParser;
use Html2Text\Html2Text;
use PhpMimeMailParser\Parser;

class EmailParseHelper
{
    private $parser;

    public $subject = '';

    public $from = [];

    public $to = [];

    public $cc = [];

    public $textBody = '';

    public $htmlBody = '';

    public $fragments = [];

    public $attachments = [];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->parser = new Parser();
    }

    /**
     * @param      $rawEmailContent
     * @param bool $includeInline
     *
     * @return array
     */
    public function parse($rawEmailContent, $includeInline = true)
    {
        // Parse the MIME formatted email
        $this->parser->setText($rawEmailContent);

        // Handle attachments
        $attachments = $this->parser->getAttachments([$includeInline]);
        foreach ($attachments as $attachment) {
            $this->attachments[] = [
                'contentType'        => $attachment->getContentType(),
                'contentDisposition' => $attachment->getContentDisposition(),
                'fileName'           => $attachment->getFilename(),
                'content'            => base64_encode($attachment->getContent()),
            ];
        }

        // Fetch data
        $this->subject = $this->parser->getHeader('subject');
        $this->to = $this->parser->getAddresses('to');
        $this->cc = $this->parser->getAddresses('cc');
        $this->from = $this->parser->getAddresses('from');
        $this->textBody = $this->parser->getMessageBody('text');
        $this->htmlBody = $this->parser->getMessageBody('html');

        // If the text content is empty, we import html
        if (empty($this->textBody)) {
            $htmlContent = new Html2Text($this->htmlBody);
            $this->textBody = $htmlContent->getText();
        }

        // Build fragments
        $fragments = EmailReplyParser::read($this->textBody)->getFragments();
        foreach ($fragments as $fragment) {
            $this->fragments[] = [
                'content'   => $fragment->getContent(),
                'empty'     => $fragment->isEmpty(),
                'quoted'    => $fragment->isQuoted(),
                'signature' => $fragment->isSignature(),
            ];
        }

        return [
            'subject'     => $this->subject,
            'to'          => $this->to,
            'cc'          => $this->cc,
            'from'        => $this->from,
            'text_body'   => $this->textBody,
            'html_body'   => $this->htmlBody,
            'fragments'   => $this->fragments,
            'attachments' => $this->attachments,
        ];
    }
}
