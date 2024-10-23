<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\ReplaceTicketRequest;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Requests\Api\V1\UpdateTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Policies\V1\TicketPolicy;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TicketController extends ApiController
{

    protected string $policyClass = TicketPolicy::class;

    /**
     * Display a listing of the resource.
     */
    public function index(TicketFilter $filters)
    {
        return TicketResource::collection(Ticket::filter($filters)->paginate());

        // if ($this->include('author')) {
        //     return TicketResource::collection(Ticket::with('user')->paginate());
        // }
        // return TicketResource::collection(Ticket::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        try {
            // RUN POLICY CHECK (V1)
            $this->authorize('store', Ticket::class);
            return new TicketResource(Ticket::create($request->mappedAttributes()));
        } catch (AuthorizationException $e) {
            return $this->error('You are not authorised to use this resource', 403);
        }

        // $model = [
        //     'title' => $request->input('data.attributes.title'),
        //     'description' => $request->input('data.attributes.description'),
        //     'status' => $request->input('data.attributes.status'),
        //     'user_id' => $request->input('data.relationships.author.data.id'),
        // ];
        // return new TicketResource(Ticket::create($model));
    }

    /**
     * Display the specified resource.
     */
    public function show($ticket_id)
    {
        try {
            $ticket = Ticket::findOrFail($ticket_id);

            if ($this->include('author')) {
                return new TicketResource($ticket->load('author'));
            }
            return new TicketResource($ticket);
        } catch (ModelNotFoundException $e) {
            return $this->error('Ticket cannot be found', 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, $ticket_id)
    {
        // PATCH,
        try {
            $ticket = Ticket::findOrFail($ticket_id);

            // RUN POLICY CHECK (V1)
            $this->authorize('update', $ticket);

            $ticket->update($request->mappedAttributes());

            return new TicketResource($ticket);
        } catch (ModelNotFoundException $e) {
            return $this->error('Ticket cannot be found', 404);
        } catch (AuthorizationException $e) {
            return $this->error('You are not authorised to update this ticket', 403);
        }
    }

    /*
     * https://tickets-please.test/api/v1/tickets/206
    {
        "data": {
            "attributes": {
            "title": "We replaced this title",
            "description": "This is the new description.",
            "status": "C"
        },
        "relationships": {
            "author": {
                "data": { "id": 1 }
                }
            }
        }
    }
     */

    public function replace(ReplaceTicketRequest $request, $ticket_id)
    {
        // PUT
        try {
            $ticket = Ticket::findOrFail($ticket_id);
            // RUN POLICY CHECK (V1)
            $this->authorize('replace', $ticket);
            $ticket->update($request->mappedAttributes());
            return new TicketResource($ticket);
        } catch (ModelNotFoundException $e) {
            return $this->error('Ticket cannot be found', 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($ticket_id)
    {
        try {
            $ticket = Ticket::findOrFail($ticket_id);
            // RUN POLICY CHECK (V1)
            $this->authorize('delete', $ticket);
            $ticket->delete();
            return $this->ok('Ticket deleted');
        } catch (ModelNotFoundException $e) {
            return $this->error('Ticket not found', 404);
        }
    }
}
