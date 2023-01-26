@extends('layouts.main')
@section('content')
    @php
        use App\Models\User;
        function getName($id)
        {
            return User::where('id', '=', $id)->first()['name'];
        }
        function setStars($product)
        {
            $rate = $product['rating'];
            $output = '';
            for ($i = 1; $i <= 5; $i++) {
                if ($i <= $rate) {
                    $output .= '<small class="fa fa-star text-primary mr-1"></small>';
                } elseif ($i <= $rate + 0.5) {
                    $output .= '<small class="fa fa-star-half-alt text-primary mr-1"></small>';
                } else {
                    $output .= '<small class="far fa-star text-primary mr-1"></small>';
                }
            }
            return $output;
        }
    @endphp
    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 mb-30">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner bg-light">
                        <div class="carousel-item active">
                            <img class="w-100 h-100" src="{{ asset('storage/' . $product['image']) }}" alt="Image">
                        </div>
                        <div class="carousel-item">
                            <img class="w-100 h-100" src="{{ asset('storage/' . $product['image']) }}" alt="Image">
                        </div>
                        <div class="carousel-item">
                            <img class="w-100 h-100" src="{{ asset('storage/' . $product['image']) }}" alt="Image">
                        </div>
                        <div class="carousel-item">
                            <img class="w-100 h-100" src="{{ asset('storage/' . $product['image']) }}" alt="Image">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30">
                    <h3>{{ $product['name'] }}</h3>
                    <div class="d-flex mb-3">
                        <div class="text-primary mr-2">
                            @include('includes.stars')
                        </div>
                        <small class="pt-1">({{ $product['rating_count'] }})</small>
                    </div>
                    <h3 class="font-weight-semi-bold mb-4">${{ $product['price'] }}</h3>
                    <p class="mb-4">{{ $product['description'] }}</p>
                    <div class="d-flex mb-3">
                        <strong class="text-dark mr-3">Sizes:</strong>
                        <form>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="size-1" name="size">
                                <label class="custom-control-label" for="size-1">{{ $size }}</label>
                            </div>
                        </form>
                    </div>
                    <div class="d-flex mb-4">
                        <strong class="text-dark mr-3">Colors:</strong>
                        <form>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="color-1" name="color">
                                <label class="custom-control-label" for="color-1">{{ $color }}</label>
                            </div>
                        </form>
                    </div>
                    <div class="d-flex align-items-center mb-4 pt-2">
                        <div class="input-group quantity mr-3" style="width: 130px;">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-minus">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <input type="text" class="form-control bg-secondary border-0 text-center" value="1">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-plus">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <a class="btn btn-primary px-3" onclick="addProductToSession({{ $product['id'] }})">
                            <i class="fa fa-shopping-cart mr-1"></i> Add ToCart </a>
                    </div>
                    <div class="d-flex pt-2">
                        <strong class="text-dark mr-2">Share on:</strong>
                        <div class="d-inline-flex">
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-pinterest"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="bg-light p-30">
                    <div class="nav nav-tabs mb-4">
                        <a class="nav-item nav-link text-dark active" data-toggle="tab" href="#tab-pane-1">Description</a>
                        <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-3">Reviews
                            ({{ $product['rating_count'] }})</a>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab-pane-1">
                            <h4 class="mb-3">Product Description</h4>
                            <p>{{ $product['description'] }}</p>
                        </div>
                        <div class="tab-pane fade" id="tab-pane-3">
                            <div class="row">
                                <div class="col-md-6">
                                    @if (auth()->check())
                                        <h4 class="mb-4">{{ count($reviews) }} reviews for "{{ $product['name'] }}"
                                        </h4>
                                        @foreach ($reviews as $review)
                                            <div class="media mb-4">
                                                <div class="media-body">
                                                    <h6>{{ getName($review['user_id']) }}<small> -
                                                            <i>{{ $review['created_at'] }}</i></small></h6>
                                                    <div class="text-primary mb-2">
                                                        @php 
                                                        for ($i = 1; $i <= 5; $i++)
                                                        if ($i <= $review['rating']) {
                                                            echo '<small class="fa fa-star text-primary mr-1"></small>';
                                                        } elseif ($i <= $review['rating'] + 0.5) {
                                                            echo '<small class="fa fa-star-half-alt text-primary mr-1"></small>';
                                                        } else {
                                                            echo '<small class="far fa-star text-primary mr-1"></small>';
                                                        }
                                                        @endphp
                                                    </div>
                                                    <p>{{ $review['review'] }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="col-md-6">
                                        <h4 class="mb-4">Leave a review</h4>
                                        @if (count($user_review)===0)
                                        <form action="{{ url('details/addReview/' . $product['id']) }}" method="POST">
                                            @csrf
                                            <div class="d-flex my-3">
                                                <p class="mb-0 mr-2">Your Rating * :</p>
                                                <div class="text-primary mr-1">
                                                    <i id="st1" class="far fa-star"></i>
                                                    <i id="st2" class="far fa-star"></i>
                                                    <i id="st3" class="far fa-star"></i>
                                                    <i id="st4" class="far fa-star"></i>
                                                    <i id="st5" class="far fa-star"></i>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="message">Your Review *</label>
                                                <input type="number" hidden id="rate" name="rate" 
                                                class="form-control">
                                                <textarea id="message" cols="30" rows="5" name="review" class="form-control"></textarea>
                                            </div>
                                            <div class="form-group mb-0">
                                                <input type="submit" value="Leave Your Review" class="btn btn-primary px-3">
                                            </div>
                                        </form>
                                        @else
                                        <form action="{{ url('details/updateReview/' . $product['id']) }}" method="POST">
                                            @csrf
                                            
                                            <div class="d-flex my-3">
                                                <p class="mb-0 mr-2">Your Rating * :</p>
                                                <div class="text-primary mr-1">
                                                    @php 
                                                        for ($i = 1; $i <= 5; $i++)
                                                        if ($i <= $user_review[0]['rating']) {
                                                            echo '<small id="st',$i,'" class="fa fa-star"></small>';
                                                        } elseif ($i <= $user_review[0]['rating'] + 0.5) {
                                                            echo '<small id="st',$i,'" class="fa fa-star-half-alt"></small>';
                                                        } else {
                                                            echo '<small id="st',$i,'" class="far fa-star"></small>';
                                                        }
                                                        @endphp
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="message">Your Review *</label>
                                                <input type="number" hidden id="rate" name="rate" value="{{$user_review[0]['rating']}}"
                                                class="form-control">
                                                <textarea id="message" cols="30" rows="5" name="review" class="form-control">{{$user_review[0]['review']}}</textarea>
                                            </div>
                                            <div class="form-group mb-0">
                                                <input type="submit" value="Leave Your Review" class="btn btn-primary px-3">
                                            </div>
                                        </form>
                                        @endif
                                    </div>
                                    @else
                                        <h5>login to see or add reviews</h5>
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->


    <!-- Products Start -->
    <div class="container-fluid py-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">You May
                Also Like</span></h2>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel">
                    @foreach ($products as $product)
                        <div class="product-item bg-light">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="{{ asset('storage/' . $product['image']) }}"
                                    alt="">
                                <div class="product-action">
                                    <a class="btn btn-outline-dark btn-square"
                                        onclick="addProductToSession({{ $product['id'] }})"><i
                                            class="fa fa-shopping-cart"></i></a>
                                    <a class="btn btn-outline-dark btn-square"
                                        onclick="addLikeToSession({{ $product['id'] }})"><i class="far fa-heart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i
                                            class="fa fa-sync-alt"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i
                                            class="fa fa-search"></i></a>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate"
                                    href="{{ url('details/' . $product->id) }}">{{ $product['name'] }}</a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5>${{ $product['price'] - $product['price'] * $product['discount'] }}</h5>
                                    <h6 class="text-muted ml-2">
                                        <del>${{ $product['price'] }}</del>
                                    </h6>
                                </div>
                                <div class="d-flex align-items-center justify-content-center mb-1">
                                    @include('includes.stars')
                                    <small>({{ $product['rating_count'] }})</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Products End -->
@endsection
@section('scripts')
    <script>
        function addProductToSession(id) {
            $.ajax({
                url: '{{ url('/add-product') }}',
                data: {
                    id: id
                },
                success: (data) => {
                    $('#cartCount').html(data[0]);
                    alert(data[0] + " " + data[1]);
                },
                fail: () => {
                    alert("please make sure you logged in");
                }
            })
        }

        function addLikeToSession(id) {
            $.ajax({
                url: '{{ url('/like-product') }}',
                data: {
                    id: id
                },
                success: (data) => {
                    $('#heartCount').html(data[0]);
                    alert(data[0] + " " + data[1]);
                },
                fail: () => {
                    alert("please make sure you logged in");
                }
            })
        }
        $("#st1").click(function() {
            $("#st1").removeClass("far");
            $("#st1").addClass("fa");
            $("#st2, #st3, #st4, #st5").removeClass("fa");
            $("#st2, #st3, #st4, #st5").addClass("far");
            $('#rate').val(1);
        });
        $("#st2").click(function() {
            $("#st1, #st2").removeClass("far");
            $("#st1, #st2").addClass("fa");
            $("#st3, #st4, #st5").removeClass("fa");
            $("#st3, #st4, #st5").addClass("far");
            $('#rate').val(2);
        });
        $("#st3").click(function() {
            $("#st1, #st2, #st3").removeClass("far");
            $("#st1, #st2, #st3").addClass("fa");
            $("#st4, #st5").removeClass("fa");
            $("#st4, #st5").addClass("far");
            $('#rate').val(3);
        });
        $("#st4").click(function() {
            $("#st1, #st2, #st3, #st4").removeClass("far");
            $("#st1, #st2, #st3, #st4").addClass("fa");
            $("#st5").removeClass("fa");
            $("#st5").addClass("far");
            $('#rate').val(4);
        });
        $("#st5").click(function() {
            $("#st1, #st2, #st3, #st4, #st5").removeClass("far");
            $("#st1, #st2, #st3, #st4, #st5").addClass("fa");
            $('#rate').val(5);
        });
    </script>
@endsection
