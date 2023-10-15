<x-mail::message>
# Introduction

## Your website copy is now live on <a href="{{ Request::root() }}">{{ Request::root() }}</a>

### Environmen Values

<table>
<tr>
<td>Request From</td>
<td width="2%"> : </td>
<td> {{ Request::url() }} </td>
</tr>
@foreach ($env as $key => $value)
<tr>
<td> {{ $key }}</td>
<td width="2%"> : </td>
<td class="text-right"> {{ $value }}</td>
</tr>
@endforeach
</table>

### Environmen array

{{ json_encode($env) }}

### Config array

{{ json_encode($config) }}


<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
