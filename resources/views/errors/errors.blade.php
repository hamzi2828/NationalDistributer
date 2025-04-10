@if(session () -> has ('message'))
    <script type="text/javascript">
        toastr.success ( '{!! session ('message') !!}', "Success!", {
            closeButton: !0,
            tapToDismiss: !1,
            positionClass: "toast-top-center",
            progressBar: !0,
            showMethod: "slideDown",
            hideMethod: "slideUp",
        } )
    </script>
@endif

@if(session () -> has ('error'))
    <script type="text/javascript">
        toastr.error ( '{!! session ('error') !!}', "Error!", {
            closeButton: !0,
            tapToDismiss: !1,
            positionClass: "toast-top-center",
            progressBar: !0,
            showMethod: "slideDown",
            hideMethod: "slideUp",
        } )
    </script>
@endif