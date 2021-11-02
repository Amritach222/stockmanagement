@extends('layouts.app')
@section('title')
    Reset your password
@endsection
@section('content')
    <table role="presentation" class="main">
        <tr>
            <td class="wrapper">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <p>Hi there,</p>
                            <p>We've received a request to reset your password. If you requested to reset your password
                                then please click the link below
                                and keep your account safe by changing your password.
                            </p>
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0"
                                   class="btn btn-primary">
                                <tbody>
                                <tr>
                                    <td align="center">
                                        <b>{{ $url . '?code=' . $code }}</b>
                                    </td>
                                </tr>
                                <tr>
                                </tr>
                                </tbody>
                            </table>
                            <span class="apple-link">Please do not reply directly to this system-generated email.</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@stop
