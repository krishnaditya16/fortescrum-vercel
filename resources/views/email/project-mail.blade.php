@component('mail::message')
# {{ $details['title'] }}
  
<h4>Project : {{ $details['project'] }}</h4>
<br>
<p>Client : {{ $details['client'] }}</p>
<p>Start Date : {{ $details['start_date'] }}</p>
<p>Due Date : {{ $details['due_date'] }}</p>
<p>Budget : ${{ $details['budget'] }}</p>
<p>Category : {{ $details['category'] }}</p>
<p>Platform : {{ $details['platform'] }}</p>

<br>
<p>For more info, please check directly by accessing the app or just click the button below.</p>
@component('mail::button', ['url' => $details['url']])
Link to Project
@endcomponent
   
Thanks,<br>
{{ $details['mail_sender'] }}<br>
(Project Manager)
@endcomponent