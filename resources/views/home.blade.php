@extends('app')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />


@auth  {{--directive--}}
<p>Welcome back , <b>{{ Auth::user()->name }}</b></p>
<a class="btn btn-primary" href="{{ route('password') }}">Change Password</a>
<a class="btn btn-danger" href="{{ route('logout') }}">Logout</a>
<a class="btn btn-info" href="{{ route('list') }}">Click here to view your images</a>

<div class="container">
              <h2>Upload an Image</h2>
        @if (session('success'))   {{--exists in session--}}
        <div>
            {{ session('success') }}
        </div>
    @endif
    
    <form method="POST" action="{{ route('img.upload') }}" enctype="multipart/form-data">
            @csrf    {{--jeton pour sécuriser les form contre les attaques CSRF.--}}
            <div class="form-group">
                <label for="image" class="form-label" style="font-weight: bold; font-size: 1.1em;">Choose Image:</label>
<input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>

            <input type="hidden" id="encryptionMethod" name="encryption_method">  {{--stocker D  envoyées au serveur lors de la soumission du formulaire--}}
        <div class="form-group mt-3">
            <label for="encryptionMethod" class="form-label" style="font-weight: bold; font-size: 1.1em;">Choose Algorithm:</label>
            <div class="btn-group d-flex flex-wrap" role="group" aria-label="Encryption Method">
            <button type="submit" class="btn btn-danger" onclick="setEncryptionMethod('cesar')">Cesar</button>
            <button type="submit" class="btn btn-primary" onclick="setEncryptionMethod('atbash')">Atbash</button>
            <button type="submit" class="btn btn-info" onclick="setEncryptionMethod('reverse')">Reverse</button>
            <button type="submit" class="btn btn-danger" onclick="setEncryptionMethod('vigenere')">Vigenère</button>
            <button type="submit" class="btn btn-primary" onclick="setEncryptionMethod('AES-256-CBC')">AES-256-CBC</button>
            <button type="submit" class="btn btn-success" onclick="setEncryptionMethod('playfair')">Playfair</button>
            <button type="submit" class="btn btn-warning" onclick="setEncryptionMethod('railfence')">Rail Fence</button>
            <button type="submit" class="btn btn-info" onclick="setEncryptionMethod('xor')">XOR</button>
            </div>
        </div>
         </form>          
</div>

<script>
    function setEncryptionMethod(method) {
        document.getElementById('encryptionMethod').value = method;
    }
</script>


@endauth
@guest

<h1>Secure Your Images</h1>
      <p>Encrypt and store your images with confidence.</p>
     

<a href="#contact-us" class="contact-us-button btn btn-secondary">Contact Us</a>
<a class="btn btn-info" href="{{ route('register') }}">Register</a>
<a class="btn btn-primary" href="{{ route('login') }}">Login</a>
<a href="#how-it-works" class="how-it-works-button btn btn-secondary">How it works</a>


<section class="welcome-section"> {{--grp of contents--}}
<table class="welcome-table">
<tr>
<td class="welcome-text">
<h1>Welcome to CryptoGallery</h1>
                <p>Here you can securely upload your images to our database, where they will be encrypted for your safety. You can later view your encrypted images on a separate page. Please register to start using the application.</p>
          
<td class="welcome-image">
    <img src="{{ asset('images/homepage.png') }}" alt="CryptoGallery">
</td>
</tr>
</table>
  </section>



<!-- How It Works Section -->
<section id="how-it-works" style="padding: 60px 20px; background-color: #fff; text-align: center;">
    <h2>How It Works</h2>
    <div class="steps-container">
        <div class="step">
            <img src="{{ asset('images/photo.png') }}" alt="Upload Icon" class="step-icon">
            <h3>Step 1</h3>
            <p>Upload your image.</p>
        </div>
        <div class="step">
            <img src="{{ asset('images/cadnat.png') }}" alt="Encryption Icon" class="step-icon">
            <h3>Step 2</h3>
            <p>Select your encryption method.</p>
        </div>
        <div class="step">
            <img src="{{ asset('images/PrivateAccess.png') }}" alt="Gallery Icon" class="step-icon">
            <h3>Step 3</h3>
            <p>View your encrypted image in your personal gallery.</p>
        </div>
    </div>
</section>

<section id="encryption-algorithms" style="padding: 60px 20px; background-color: #f4f4f4; text-align: center;">
    <h2>Some Cryptographic Algorithms Used</h2>
    <div class="algorithms-container">
        <div class="algorithm">
            <h3>Cesar Cipher</h3>
            <p>The Cesar Cipher is one of the simplest and most widely known encryption techniques. It shifts the letters of the alphabet by a fixed number.</p>
        </div>
        <div class="algorithm">
            <h3>Atbash Cipher</h3>
            <p>Atbash is a simple substitution cipher where the first letter of the alphabet is substituted with the last, the second with the second last, and so on.</p>
        </div>
        <div class="algorithm">
            <h3>Reverse Cipher</h3>
            <p>The Reverse Cipher is a simple encryption technique where the text is reversed. Each character in the message is substituted by its reverse position in the string.</p>
            </div>
    </div>
</section>



<section id="contact-us">
    <h2>Contact Us</h2>
    <p>We're here to help. Feel free to reach out with any questions or inquiries.</p>
    <ul class="contact-details">
        <li>
            <i class="fas fa-envelope"></i>
            <a href="mailto:assilbarhoumi222222@gmail.com">assilbarhoumi222222@gmail.com</a>
        </li>
        <li>
            <i class="fas fa-phone"></i> 
            <a href="tel:+21612345678">+216 12 345 678</a>
        </li>
        <li>
            <i class="fas fa-map-marker-alt"></i>
            <address>Freedom City, Tunisia</address>
        </li>
    </ul>
</section>
<!-- Icons can be from an icon library like FontAwesome or custom images -->
<script src="{{ asset('js/script.js') }}"></script>



@endguest
@endsection