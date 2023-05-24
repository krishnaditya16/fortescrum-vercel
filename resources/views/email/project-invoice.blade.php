@component('mail::message')
# {{ $details['title'] }}
  
<h4>Invoice : #INV-{{ $details['invoice'] }}</h4>
<br>
<p>Project : {{ $details['project'] }}</p>
<p>Client : {{ $details['client'] }}</p>
<p>Issued Date : {{ $details['issued_date'] }}</p>
<p>Due Date : {{ $details['due_date'] }}</p>
<p>Total : ${{ $details['total'] }}</p>

<br>
<p>For more info, please check directly by accessing the app or just click the button below.</p>
@component('mail::button', ['url' => $details['url']])
Link to Invoice
@endcomponent
   
Thanks,<br>
{{ $details['mail_sender'] }}<br>
(Project Manager)
@endcomponent