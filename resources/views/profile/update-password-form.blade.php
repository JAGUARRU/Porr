<x-form-section submit="updatePassword">
    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-label for="current_password" value="รหัสผ่านปัจจุบัน" />
            <x-input id="current_password" type="password" class="block w-full mt-1" wire:model.defer="state.current_password" autocomplete="current-password" />
            <x-input-error for="current_password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password" value="รหัสผ่านใหม่" />
            <x-input id="password" type="password" class="block w-full mt-1" wire:model.defer="state.password" autocomplete="new-password" />
            <x-input-error for="password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password_confirmation" value="ยืนยันรหัสผ่านใหม่" />
            <x-input id="password_confirmation" type="password" class="block w-full mt-1" wire:model.defer="state.password_confirmation" autocomplete="new-password" />
            <x-input-error for="password_confirmation" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="mr-3" on="saved">
            บันทึกสำเร็จ
        </x-action-message>

        <x-button>
            บันทึก
        </x-button>
    </x-slot>
</x-form-section>