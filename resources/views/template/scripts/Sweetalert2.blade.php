<script type="text/javascript">
    $(function() {
        $(document).on('click', '#delete', function(e) {
            e.preventDefault();
            var link = $(this).attr("href");
            Swal.fire({
                title: '{{ __("Are you sure") }}?',
                text: '{{ __("Delete this data") }}?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: '{{ __("Cancel") }}',
                confirmButtonText: '{{ __("Yes, delete it") }}!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = link;
                    Swal.fire(
                        '{{ __("Deleted") }}!',
                        '{{ __("Your file has been deleted.") }}',
                        '{{ __("successful") }}'
                    );
                }
            });
        });
    });
    </script>
    
    <script type="text/javascript">
    $(function() {
        $(document).on('click', '#pdelete', function(e) {
            e.preventDefault();
            var link = $(this).attr("href");
            Swal.fire({
                title: '{{ __("Are you sure") }}?',
                text: '{{ __("Delete this data permanently") }}?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: '{{ __("Cancel") }}',
                confirmButtonText: '{{ __("Yes, delete it") }}!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = link;
                    Swal.fire(
                        '{{ __("Deleted") }}!',
                        '{{ __("Your file has been permanently deleted.") }}',
                        '{{ __("successful") }}'
                    );
                }
            });
        });
    });
    </script>

    
    <style>
        .colored-toast.swal2-icon-success {
  background-color: #a5dc86 !important;
}

.colored-toast.swal2-icon-error {
  background-color: #f27474 !important;
}

.colored-toast.swal2-icon-warning {
  background-color: #f8bb86 !important;
}

.colored-toast.swal2-icon-info {
  background-color: #3fc3ee !important;
}

.colored-toast.swal2-icon-question {
    background-color: #87adbd !important;
}

.colored-toast .swal2-title {
  color: white;
}

.colored-toast .swal2-close {
  color: white;
}

.colored-toast .swal2-html-container {
  color: white;
}
      </style>


<script>
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-right',
      iconColor: 'white',
      customClass: {
        popup: 'colored-toast'
      },
      showConfirmButton: false,
      timer: 1500,
      timerProgressBar: true
    });
  
    @if(Session::has('message'))
      var type = "{{ Session::get('alert-type','info') }}";
      switch (type) {
        case 'info':
          Toast.fire({
            icon: 'info',
            title: '{{ __("Information") }}',
            text: "{{ Session::get('message') }}"
          });
          break;
        case 'success':
          Toast.fire({
            icon: 'success',
            title: '{{ __("Success") }}',
            text: "{{ Session::get('message') }}"
          });
          break;
        case 'warning':
          Toast.fire({
            icon: 'warning',
            title: '{{ __("Warning") }}',
            text: "{{ Session::get('message') }}"
          });
          break;
        case 'error':
          Toast.fire({
            icon: 'error',
            title: '{{ __("Error") }}',
            text: "{{ Session::get('message') }}"
          });
          break;
        case 'question':
          Swal.fire({
            icon: 'info',
            title: '{{ __("Information") }}',
            timer: 10000,
            showConfirmButton: true,
            text: "{{ Session::get('message') }}"
          });
          break;

      }
    @endif
  </script>
        
    