<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\ReplaceTicketRequest;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Requests\Api\V1\UpdateTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthorTicketsController extends ApiController
{
    public function index($author_id, TicketFilter $filters)
    {
        return TicketResource::collection(
            Ticket::where('user_id', $author_id)
                ->filter($filters)->paginate()
        );
    }

    public function replace(ReplaceTicketRequest $request,$author_id, $ticket_id)
    {
        // PUT
        try {
            $ticket = Ticket::findOrFail($ticket_id);

            if ($ticket->user_id == $author_id) {
                $ticket->update($request->mappedAttributes());
            }
            // TODO: Ticket doesn't belong to user

            return new TicketResource($ticket);
        } catch (ModelNotFoundException $e) {
            return $this->error('Ticket cannot be found', 404);
        }
    }

    public function store(StoreTicketRequest $request, $author_id)
    {
        // DEFINITELY BROKEN see POST Author Tickets and test
        //$request->merge(['data.relationships.author.data.id' => $author_id]);
        //return new TicketResource(Ticket::create($request->mappedAttributes()));

        // THIS WORKS BUT THERE MUST BE A WAY TO FIX ABOVE
        $model = [
            'title' => $request->input('data.attributes.title'),
            'description' => $request->input('data.attributes.description'),
            'status' => $request->input('data.attributes.status'),
            'user_id' => $author_id,
        ];
        return new TicketResource(Ticket::create($model));
    }

    public function update(UpdateTicketRequest $request, $author_id, $ticket_id)
    {
        // PATCH
        try {
            $ticket = Ticket::findOrFail($ticket_id);

            if ($ticket->user_id == $author_id) {
                $ticket->update($request->mappedAttributes());
            }
            // TODO: Ticket doesn't belong to user

            return new TicketResource($ticket);
        } catch (ModelNotFoundException $e) {
            return $this->error('Ticket cannot be found', 404);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($author_id, $ticket_id)
    {
        try {
            $ticket = Ticket::findOrFail($ticket_id);

            if ($ticket->user_id == $author_id) {
                $ticket->delete();
                return $this->ok('Ticket deleted');
            }

            return $this->error('Ticket not found', 404);
        } catch (ModelNotFoundException $e) {
            return $this->error('Ticket not found', 404);
        }
    }


}
