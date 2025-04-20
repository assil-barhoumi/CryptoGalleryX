<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\CesarCipherService;
use App\Services\VigenereCipherService;
use App\Services\AtbashCipherService;
use App\Services\ReverseCipherService;
use App\Services\PlayfairCipherService;
use App\Services\RailFenceCipherService;
use App\Services\XORCipherService;
use App\Models\EncryptedImg;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class ImgController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([  // data sent via req
            'image' => 'required|image|max:2048',  //champs image
            'encryption_method' => 'required|string',
        ]);
        // Lire contenu
        $imageContent = file_get_contents($request->file('image'));
        $encryptionMethod = $request->input('encryption_method');
        // Cryptage 
        if ($encryptionMethod === 'cesar') {
        $cesarShifts = config('app.cesar_shifts');
        $cesarKey = $cesarShifts[4];
        $cesarCipher = new CesarCipherService($cesarKey);
        $encryptedImageData = $cesarCipher->encrypt($imageContent);
        $base64EncodedData = base64_encode($encryptedImageData);
        }
        elseif ($encryptionMethod === 'atbash') {
            $atbashCipher=new AtbashCipherService();
            $encryptedImageData = $atbashCipher->encrypt_decrypt($imageContent);
            $base64EncodedData = base64_encode($encryptedImageData);
        }
        elseif ($encryptionMethod === 'reverse') {
              $reverseCipher = new ReverseCipherService();
            $encryptedImageData = $reverseCipher->encryptDecrypt($imageContent);
            $base64EncodedData = base64_encode($encryptedImageData);
        }
        elseif ($encryptionMethod === 'vigenere') {
            $vigenereCipher = new VigenereCipherService();
            $encryptedImageData = $vigenereCipher->encrypt($imageContent);
            $base64EncodedData = base64_encode($encryptedImageData);
        }
        elseif ($encryptionMethod === 'playfair') {
            $playfairCipher = new PlayfairCipherService();
            $encryptedImageData = $playfairCipher->encrypt($imageContent);
            $base64EncodedData = base64_encode($encryptedImageData);
        }
        elseif ($encryptionMethod === 'railfence') {
            $railFenceCipher = new RailFenceCipherService();
            $encryptedImageData = $railFenceCipher->encrypt($imageContent);
            $base64EncodedData = base64_encode($encryptedImageData);
        }
        elseif ($encryptionMethod === 'xor') {
            $xorKey = 'mysecretkey'; 
            $xorCipher = new XORCipherService();
            $encryptedImageData = $xorCipher->encrypt($imageContent, $xorKey);
            $base64EncodedData = $encryptedImageData;
        }
        elseif ($encryptionMethod === 'AES-256-CBC') {
             $encryptedImageData = Crypt::encrypt($imageContent);
            $base64EncodedData = base64_encode($encryptedImageData);
        }

        // Sauvegarde ds bdd
        $encryptedImage = new EncryptedImg();
        $encryptedImage->user_id = Auth::id(); 
        $encryptedImage->encrypted_data = $base64EncodedData;
        $encryptedImage->encryption_method = $encryptionMethod;
  
        $encryptedImage->save();
       # return view('home')->with('success', 'Image uploadée et cryptée avec succès.');
       return redirect()->back()->with('success', 'Image uploaded and encrypted successfully.');
}
public function showImages_Users()
{
    $images = EncryptedImg::where('user_id', Auth::id())->get();

    foreach ($images as $image) {
        $decryptedImageData = base64_decode($image->encrypted_data);

        if ($image->encryption_method === 'cesar') {
            $cesarShifts = config('app.cesar_shifts');
            $cesarKey = $cesarShifts[4];
            $cesarCipher = new CesarCipherService($cesarKey);
            $decryptedImage = $cesarCipher->decrypt($decryptedImageData);
        } elseif ($image->encryption_method === 'atbash') {
            $atbashCipher = new AtbashCipherService();
            $decryptedImage = $atbashCipher->encrypt_decrypt($decryptedImageData);
        }elseif ($image->encryption_method === 'reverse') {
            $reverseCipher = new ReverseCipherService();
            $decryptedImage = $reverseCipher->encryptDecrypt($decryptedImageData);
        }
        elseif ($image->encryption_method === 'vigenere') {
            $vigenereCipher = new VigenereCipherService();
            $decryptedImage = $vigenereCipher->Decrypt($decryptedImageData);
        }
        elseif ($image->encryption_method === 'playfair') {
            $playfairCipher = new PlayfairCipherService();
            $decryptedImage = $playfairCipher->decrypt($decryptedImageData);
        }
        elseif ($image->encryption_method === 'railfence') {
            $railFenceCipher = new RailFenceCipherService();
            $decryptedImage = $railFenceCipher->decrypt($decryptedImageData);
        }
        elseif ($image->encryption_method === 'xor') {
            $xorKey = 'mysecretkey'; 
            $xorCipher = new XORCipherService();
            $decryptedImage = $xorCipher->decrypt($image->encrypted_data, $xorKey);
        }
        elseif ($image->encryption_method === 'AES-256-CBC') {
            $decryptedImage = Crypt::decrypt($decryptedImageData);
        }
        else {
            $decryptedImage = null;
        }
        $image->decrypted_data = base64_encode($decryptedImage);
    }
    #$users = User::all(); // Récupère tous les utilisateurs
 


 $users = User::where('user_id', '!=', Auth::id())->get();

    return view('list', compact('images','users'));  
}

public function deleteImage($id)
{
    $image = EncryptedImg::where('id', $id)->where('user_id', Auth::id())->first(); //récupère la première entrée qui correspond aux conditions spécifiées

    if ($image) {

        $image->delete();

        return redirect()->back()->with('success', 'Image deleted successfully.');
    } else {
        return redirect()->back()->with('error', 'Image not found or unauthorized.');
    }
}

}

