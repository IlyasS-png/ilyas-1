<div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div class=".flex.flex-col gap-6">

        <div class="rounded-xl border">
            <br>
            <flux:heading class="px-10" size="xl">{{ $productID ? 'Edit Product' : 'Add Product' }}</flux:heading>
            <div class="px-10 py-8">
                <form wire:submit.prevent="save" class="space-y-6">
                    <flux:input wire:model="name" label="Product Name" placeholder="Product Name" />
                    <flux:input wire:model="description" label="Description"
                        placeholder="Description" />
                    <flux:input wire:model="price" label="Price" placeholder="Berapoo" />
                    <flux:button type="submit" variant="primary">Submit</flux:button>
                </form>
            </div>
        </div>
        <br>
        <div class="text-green-600 p-5 font-textbold">{{ session('message') }}</div>
        <br>
        <div class="rounded-xl border">
            <br>
            <div class="px-10 py-8">
                <table class="w-full">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th class="text-left">Product Name</th>
                            <th class="text-left">Description</th>
                            <th class="text-left">Price</th>
                            <th class="text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $p)
                            <tr>
                                <td class="text-center">{{ $p->id }}</td>
                                <td class="text-center">{{ $p->name }}</td>
                                <td class="text-center">{{ $p->description }}</td>
                                <td class="text-center">{{ $p->price }}</td>
                                <td class="flex gap-2 justify-center">
                                    <flux:button wire:click="edit({{ $p->id }})" icon="pencil" variant="filled">Edit</flux:button>
                                    <flux:button wire:click="$dispatch('confirmDelete',{{ $p->id }})" icon="trash" variant="danger">Delete</flux:button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
            <div class="text-center">{{ $products ->links() }}</div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('livewire:init', function() {
        Livewire.on('productSaved', function(res) {
            Swal.fire('Hmm', res.message, 'success');
        });
        Livewire.on('confirmDelete', function(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('delete', {id: id});
                }
            });
                        
        });
    });
</script>
