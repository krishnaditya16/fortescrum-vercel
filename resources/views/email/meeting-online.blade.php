@component('mail::message')
# {{ $details['title'] }}
  
<h4>Meeting Date : {{ $details['meeting_date'] }}</h4>
<br>
<p>From : {{ $details['start_time'] }}</p>
<p>To : {{ $details['end_time'] }}</p>
<p>Type : {{ $details['type'] }}</p>
<p>URL : {{ $details['meeting_link'] }}</p>

<br>
<p>For more info, please check directly by accessing the app or just click the button below.</p>
@component('mail::button', ['url' => $details['url']])
Link to Project
@endcomponent
   
Thanks,<br>
{{ $details['mail_sender'] }}<br>
(Project Manager)
@endcomponent