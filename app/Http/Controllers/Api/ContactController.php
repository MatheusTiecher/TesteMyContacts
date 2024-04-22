<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use App\Services\LocationService;
use App\Traits\ResponseCreator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    use ResponseCreator;

    protected $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $user = Auth::user();

            $contacts = Contact::where('type', $request->type)
                ->where('user_id', $user->id)
                ->where(function ($query) use ($request) {
                    $query->whereRaw("unaccent(name) ilike unaccent(?)", ['%' . $request->search . '%'])
                        ->orWhereRaw("unaccent(cpf) ilike unaccent(?)", ['%' . $request->search . '%']);
                })
                ->get();

            return $this->createResponseSuccess($contacts, 200, 'Contatos listados com sucesso');
        } catch (\Exception $e) {
            return $this->createResponseInternalError($e);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validador = validator()->make($request->all(), (new StoreContactRequest())->rules());

            if ($validador->fails()) {
                return $this->createResponseBadRequest('Erro de validação', $validador->errors(), 422);
            }

            $user = Auth::user();

            $newContact = $user->contacts()->create($validador->validated());

            // adiciona latitude e longitude ao contato
            $coodinate = $this->locationService->getCoordinatesByAddress($newContact);
           
            $newContact->update([
                'latitude' => $coodinate['latitude'],
                'longitude' => $coodinate['longitude']
            ]);

            return $this->createResponseSuccess($newContact, 201, 'Contato criado com sucesso');
        } catch (\Exception $e) {
            return $this->createResponseInternalError($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        try {
            $user = Auth::user();

            if ($contact->user_id !== $user->id) {
                throw new \Exception('Você não tem permissão para acessar este contato', 403);
            }

            return $this->createResponseSuccess($contact, 200, 'Contato listado com sucesso');
        } catch (\Exception $e) {
            return $this->createResponseInternalError($e);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        try {

            $validador = validator()->make($request->all(), (new UpdateContactRequest())->rules());

            if ($validador->fails()) {
                return $this->createResponseBadRequest('Erro de validação', $validador->errors(), 422);
            }

            $user = Auth::user();

            if ($contact->user_id !== $user->id) {
                throw new \Exception('Você não tem permissão para acessar este contato', 403);
            }

            $contact->update($validador->validated());

            return $this->createResponseSuccess(null, 204, 'Contato atualizado com sucesso');
        } catch (\Exception $e) {
            return $this->createResponseInternalError($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        try {
            $user = Auth::user();

            if ($contact->user_id !== $user->id) {
                throw new \Exception('Você não tem permissão para acessar este contato', 403);
            }

            $contact->delete();

            return $this->createResponseSuccess(null, 204, 'Contato deletado com sucesso');
        } catch (\Exception $e) {
            return $this->createResponseInternalError($e);
        }
    }
}
