<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .form-labels {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
        }

        .form-label {
            flex: 1;
            text-align: center;
            font-weight: bold;
        }

        .plo-outcome {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .plo-outcome .form-control {
            margin: 0 5px;
            flex: 1 0 30%;
            min-width: 100px;
        }

        .remove-outcome {
            margin-left: 10px;
        }
    </style>

    <div class="py-16">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('plos.index') }}" class="btn btn-secondary mb-3">Quay lại</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="py-14">
                        <h1>Tạo PLO (Program Learning Outcomes)</h1>
                        <form action="{{ route('plos.store') }}" method="POST">
                            @csrf

                            <div class="plo-outcome-container">

                                <div class="form-labels">
                                    <div class="form-label">Chọn Chuyên Ngành</div>
                                    <div class="form-label">Tên PLO</div>
                                    <div class="form-label">Mô tả</div>
                                </div>

                                <div id="plo-outcomes-container">
                                    <div class="plo-outcome">
                                        <!-- Chọn chuyên ngành -->
                                        <div class="form-group">
                                            <select id="major_id" name="major_id[]" class="form-control select2" required>
                                                <option value="">Chọn chuyên ngành</option>
                                                @foreach ($allMajors as $major)
                                                    <option value="{{ $major->id }}">{{ $major->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('major_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Tên PLO -->
                                        <div class="mb-3">
                                            <input type="text" class="form-control" id="name" name="name[]" value="{{ old('name') }}" required>
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Mô tả -->
                                        <div class="mb-3">
                                            <textarea class="form-control" id="description" name="description[]">{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Hidden field lưu mã chuyên ngành -->
                                        <input type="hidden" id="initial_major_id" name="initial_major_id" value="">

                                        <button type="button" class="btn btn-danger remove-outcome">Remove</button>
                                    </div>
                                </div>
                            </div>

                            <button type="button" id="add-plo" class="btn btn-secondary">Add More</button>
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
$(document).ready(function() {
    // Khởi tạo select2 cho các phần tử hiện có
    $('.select2').select2({
        placeholder: "Chọn chuyên ngành",
        allowClear: true
    });

    // Khi người dùng chọn chuyên ngành đầu tiên, lưu ID vào trường ẩn
    $('#major_id').change(function() {
        $('#initial_major_id').val($(this).val());
        console.log('Chuyên ngành đã chọn:', $(this).val()); // In ra giá trị để kiểm tra
    });

    // Xử lý nút Add More
    $('#add-plo').click(function() {
        console.log('Nút Add More đã được nhấn'); // Thêm dòng này để kiểm tra
        const initialMajorId = $('#initial_major_id').val();

        if (initialMajorId) {
            const $container = $('#plo-outcomes-container');
            const $newOutcome = $('.plo-outcome').first().clone();

            // Thay thế select bằng input hidden chứa major_id
            $newOutcome.find('.form-group').html(`<input type="hidden" name="major_id[]" value="${initialMajorId}">`);

            // Xóa giá trị của các input fields khác
            $newOutcome.find('input:not([type=hidden]), textarea').val('');

            $container.append($newOutcome);
        } else {
            alert('Vui lòng chọn chuyên ngành đầu tiên trước khi thêm nhóm mới.');
        }
    });
});
</script>
