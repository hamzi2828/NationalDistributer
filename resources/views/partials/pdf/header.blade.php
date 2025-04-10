@if(!empty($settings) && $settings -> settings -> display_on_pdf == '1')
    <table width="100%" border="0" cellpadding="0" cellspacing="0"
           style="margin-bottom: 0; border-bottom: 1px solid #000000">
        <tbody>
        <tr>
            <td width="50%" align="left" style="padding: 0; margin: 0">
                <img width="100"
                     src="{{ !empty(trim ($settings -> settings -> logo)) ? asset ($settings -> settings -> logo) : asset ('/assets/img/default-thumbnail.jpg') }}">
            </td>
            <td width="50%" align="right">
                <span style="font-size: 18px; margin: 0; padding: 0">
                    <strong>{{ $settings -> settings -> title }}</strong>
                </span> <br />
                @if(!empty(trim ($settings -> settings -> email)))
                    <span style="font-size: 12px;">&#x2709; {{ $settings -> settings -> email }}</span><br />
                @endif
                @if(!empty(trim ($settings -> settings -> phone)))
                    <span style="font-size: 12px;">&#x260E; {{ $settings -> settings -> phone }}</span><br />
                @endif
                @if(!empty(trim ($settings -> settings -> address)))
                    <span style="font-size: 12px;">{{ $settings -> settings -> address }}</span><br />
                @endif
            </td>
        </tr>
        </tbody>
    </table>
@endif
