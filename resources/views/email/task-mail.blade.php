@component('mail::message')
# {{ $details['title'] }}
  
<h4>Task : {{ $details['task'] }}</h4>
<br>
<p>Project : {{ $details['project'] }}</p>
<p>Sprint Iteration : Sprint - {{ $details['sprint'] }}</p>
<p>Backlog : {{ $details['backlog'] }}</p>

<br>
<p>For more info, please check directly by accessing the app or just click the button below.</p>
@component('mail::button', ['url' => $details['url']])
Link to Project
@endcomponent
   
Thanks,<br>
{{ $details['mail_sender'] }}<br>
(Project Manager)
@endcomponent