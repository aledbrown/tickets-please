<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\ReplaceTicketRequest;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Requests\Api\V1\UpdateTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Models\Ticket;
use App\Models\User;
use App\Policies\V1\TicketPolicy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthorTicketsController extends ApiController
{
    protected string $policyClass = TicketPolicy::class;

    public function index(User $author, TicketFilter $filters)
    {
        return TicketResource::collection(
            Ticket::where('user_id', $author->id)
                ->filter($filters)->paginate()
        );
    }

    // public function replace(ReplaceTicketRequest $request, User $author, Ticket $ticket)
    // {
    //     // PUT
    //     if ($this->authorize('replace', $ticket)) {
    //         $ticket->update($request->mappedAttributes());
    //         return new TicketResource($ticket);
    //     }
    //     return $this->notAuthorized('You are not authorized to update that resource');
    // }

    public function replace(ReplaceTicketRequest $request, $author_id, $ticket_id)
    {
        // PUT
        try {
            $ticket = Ticket::where('id', $ticket_id)
                ->where('user_id', $author_id)
                ->firstOrFail();

            // RUN POLICY CHECK (V1)
            $this->authorize('replace', $ticket);

            $ticket->update($request->mappedAttributes());
            return new TicketResource($ticket);
        } catch (ModelNotFoundException $e) {
            return $this->error('Ticket cannot be found', 404);
        } catch (AuthorizationException $e) {
            return $this->error('You are not authorised to update this resource', 403);
        }
    }

    public function store(StoreTicketRequest $request, $author_id)
    {
        try {
            // RUN POLICY CHECK (V1)
            $this->authorize('store', Ticket::class);
            return new TicketResource(Ticket::create($request->mappedAttributes([
                'author' => 'user_id',
            ])));
        } catch (AuthorizationException $e) {
            return $this->error('You are not authorised to create this resource', 403);
        }

        // THIS WORKS - THE ABOVE NOW DOES THE SAME TOO
        // $model = [
        //     'title' => $request->input('data.attributes.title'),
        //     'description' => $request->input('data.attributes.description'),
        //     'status' => $request->input('data.attributes.status'),
        //     'user_id' => $author_id,
        // ];
        // return new TicketResource(Ticket::create($model));
    }

    public function update(UpdateTicketRequest $request, $author_id, $ticket_id)
    {
        // PATCH
        try {
            $ticket = Ticket::where('id', $ticket_id)
                ->where('user_id', $author_id)
                ->firstOrFail();

            // RUN POLICY CHECK (V1)
            $this->authorize('update', $ticket);

            $ticket->update($request->mappedAttributes());
            return new TicketResource($ticket);
        } catch (ModelNotFoundException $e) {
            return $this->error('Ticket cannot be found', 404);
        } catch (AuthorizationException $e) {
            return $this->error('You are not authorised to update this resource', 403);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($author_id, $ticket_id)
    {
        try {
            $ticket = Ticket::where('id', $ticket_id)
                ->where('user_id', $author_id)
                ->firstOrFail();

            // RUN POLICY CHECK (V1)
            $this->authorize('delete', $ticket);

            $ticket->delete();
            return $this->ok('Ticket deleted');
        } catch (ModelNotFoundException $e) {
            return $this->error('Ticket not found', 404);
        } catch (AuthorizationException $e) {
            return $this->error('You are not authorised to delete this resource', 403);
        }
    }


}
