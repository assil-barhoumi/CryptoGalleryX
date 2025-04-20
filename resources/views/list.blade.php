<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
</head>
<body style="background: linear-gradient(135deg, #e0e7ff 0%, #f8fafc 100%); min-height: 100vh;">
<div class="container mt-5" style="background: rgba(255,255,255,0.95); border-radius: 18px; box-shadow: 0 8px 24px rgba(80,120,220,0.12); padding: 36px 24px;">

{{-- Success Message --}}
@if (session('success'))
    <div id="success-message" class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

{{-- Error Message --}}
@if (session('error'))
    <div id="error-message" class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif


   {{-- <h1>slt <b>{{ Auth::user()->name }}</b><h1>--}}
    <h2 class="mt-4">Your Images</h2>
       <div class="row">  
       
                @forelse ($images as $image)
               <tr>
                <td style="width: 200px; height: 200px; overflow: hidden;">
               <div class="col-md-4 mb-4"> 
                    <div class="card shadow-lg border-0" style="height: 100%; display: flex; align-items: center; justify-content: center; border-radius: 16px; background: #f5faff;">
                    <img src="data:image/jpeg;base64,{{ $image->decrypted_data }}" class="card-img-top" alt="Image">
                    <div class="card-body">
                    <form action="{{ route('images.delete', $image->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger mt-2" style="width:100%;">Delete</button>
                    </form>
                    </div>
                </div>
                </div>
                </td>
                </tr>

                @empty 
                <div class="col-md-12">
                    <p>No images uploaded yet.</p>
                </div>
            @endforelse
        </div>



            <a class="btn btn-info" href="{{ route('home') }}">Click here to back to the home page</a>



{{-- JavaScript to auto-hide success and error messages --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var successMessage = document.getElementById('success-message');
        var errorMessage = document.getElementById('error-message');

        if (successMessage) {
            setTimeout(function() {
                successMessage.style.display = 'none';
            }, 5000); 
        }

        if (errorMessage) {
            setTimeout(function() {
                errorMessage.style.display = 'none';
            }, 5000); 
        }
    });
</script>
</body>
</html>