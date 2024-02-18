<x-mail::message>
# Introduction

## Your website copy is now live on <a href="{{ Request::root() }}">{{ Request::root() }}</a>

### Environmen Values

<table>
<tr>
<td>Request From</td>
<td width="2%"> : </td>
<td> <a href="{{ Request::url() }}">{{ Request::url() }}</a> </td>
</tr>
</table>



<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
