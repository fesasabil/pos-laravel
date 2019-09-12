<div class="col-md-4">
    @card
        @slot('title')
            Cart
        @endslot

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Harga</th>
                        <th>QTY</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="(row.index) in shoppingCart">
                        <td>@{{ row.name }} (@{{ row.code }})</td>
                        <td>@{{ row.price | currency }}</td>
                        <td>@{{ row.qty }}</td>
                        <td>
                            <button @click.prevent="removeCart(index)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        @slot('footer')
        <div class="card-footer text-muted">
            @if(url()->curret() == route('order.transaction'))
            <a href="{{ route('order.checkout') }}" class="btn btn-secondary btn-sm float-right">Checkout</a>
            @else
            <a href="{{ route('order.transaction') }}" class="btn btn-secondary btn-sm float-right">Back</a>
            @endif
        </div>
        @endslot
    @endcard
</div>