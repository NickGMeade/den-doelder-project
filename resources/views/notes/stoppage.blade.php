@extends('layouts.app')

@section('content')
    <br>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-gradient-olive">
                <h3 class="text-center">Add the reason of pausing Order #{{$order->order_number}}</h3>
            </div>
            <div class="card-body">
                <form class="was-validated" method="POST" action="{{ route('notes.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="requirednote" for="title">Title</label>
                        <div>
                            <input class="form-control" name="title"
                                   type="text" placeholder="Title of note" value="{{old('title')}}" required>
                        </div>
                        @error('title')
                        <p>{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="requirednote" for="content">Content</label>
                        <div>
                            <textarea type="text" class="form-control @error('content') is-invalid @enderror"
                                      name="content"
                                      placeholder="Please describe the error occurred in more detail." rows="5" required
                            >{{old('content')}}</textarea>
                        </div>
                        @error('content')
                        <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="label" value="Mechanical Issue (Error)"
                                       required>Mechanical Issue
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="label" value="Material Issue (Error)"
                                       required>Material Issue
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="label" value="Technical Issue (Error)"
                                       required>Technical Issue
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="label" value="Lunch Break"
                                       required>Lunch Break
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="label" value="End of Shift"
                                       required>End of Shift
                            </div>
                            <br>
                        </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="label" value="stoppage" style="display:none"
                               checked>
                    </div>

                    <button type="submit" class="btn btn-lg btn-block bg-gradient-olive">Log reason of stoppage</button>
                </form>
            </div>
        </div>
    </div>
@endsection


