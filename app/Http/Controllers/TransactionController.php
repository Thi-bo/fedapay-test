<?php

namespace App\Http\Controllers;

use FedaPay\FedaPay;
use FedaPay\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct()
    {
        // Configurer la clé API FedaPay et l'environnement depuis le fichier de configuration
        FedaPay::setApiKey(config('fedapay.api_key'));
        FedaPay::setEnvironment(config('fedapay.environment'));
    }

    public function showForm()
    {
        return view('create_transaction');
    }

    public function createTransaction(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email',
            'phone_number' => 'required|string',
        ]);

        try {
            // Créer la transaction FedaPay
            $transaction = Transaction::create([
                "description" => "Transaction pour {$request->email}",
                "amount" => 2000,
                "currency" => ["iso" => "XOF"],
                "callback_url" => route('fedapay.callback'),
                "customer" => [
                    "firstname" => $request->firstname,
                    "lastname" => $request->lastname,
                    "email" => $request->email,
                    "phone_number" => [
                        "number" => $request->phone_number,
                        "country" => "bj"
                    ]
                ]
            ]);

            // Générer un token pour le paiement et rediriger l'utilisateur
            $token = $transaction->generateToken();
            return redirect()->to($token->url);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function callback(Request $request)
    {
        $transactionId = $request->query('id'); // ID de transaction de FedaPay

        try {
            // Récupérer la transaction pour vérifier le statut
            $transaction = Transaction::retrieve($transactionId);

            // Passer les informations de la transaction à une seule vue
            return view('callback_result', [
                'status' => $transaction->status,
                'amount' => $transaction->amount,
                'reference' => $transaction->reference,
                'message' => $this->getStatusMessage($transaction->status)
            ]);
        } catch (\Exception $e) {
            return view('callback_result')->withErrors([
                'error' => 'Erreur de récupération de la transaction: ' . $e->getMessage()
            ]);
        }
    }

    private function getStatusMessage($status)
    {
        switch ($status) {
            case 'approved':
                return 'Paiement approuvé!';
            case 'declined':
                return 'Paiement refusé.';
            case 'canceled':
                return 'Le paiement a été annulé.';
            case 'refunded':
                return 'Le paiement a été remboursé.';
            case 'transferred':
                return 'Le paiement a été transféré.';
            case 'pending':
            default:
                return 'Le paiement est en attente de confirmation.';
        }
    }
}
