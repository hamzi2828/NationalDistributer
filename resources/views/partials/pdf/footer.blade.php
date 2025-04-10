@if(!empty($settings) && !empty(trim ($settings -> settings -> pdf_footer_content)))
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tbody>
        <tr>
            <td width="100%" align="left" style="padding: 0; margin: 0">
                {!! $settings -> settings -> pdf_footer_content !!}
            </td>
        </tr>
        </tbody>
    </table>
@endif
