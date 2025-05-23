<div>
    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <form wire:submit.prevent="submit" enctype="multipart/form-data">
        <div class="form-group">
            <label for="teamID">Select Team</label>
            <select wire:model="teamID" class="form-control" id="teamID" required>
                <option value="">Select Team</option>
                @foreach ($teams as $team)
                    <option value="{{ $team->TeamID }}">{{ $team->TeamName }}</option>
                @endforeach
            </select>
            @error('teamID') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="salesPitchFileName">Sales Pitch File Name</label>
            <input wire:model="salesPitchFileName" type="text" class="form-control" id="salesPitchFileName" required>
            @error('salesPitchFileName') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="salesPitchFileType">Sales Pitch File Type</label>
            <select wire:model="salesPitchFileType" class="form-control" id="salesPitchFileType" required>
                <option value="">Select File Type</option>
                <option value="PDF">PDF</option>
                <option value="PPT">PPT</option>
                <option value="MOV">MOV</option>
                <option value="DOC">DOC</option>
                <option value="DOCX">DOCX</option>
            </select>
            @error('salesPitchFileType') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="salesPitchFile">Upload Sales Pitch File</label>
            <input wire:model="salesPitchFile" type="file" class="form-control-file" id="salesPitchFile" required>
            @error('salesPitchFile') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="prototypePhotoFileName">Prototype Photo File Name</label>
            <input wire:model="prototypePhotoFileName" type="text" class="form-control" id="prototypePhotoFileName" required>
            @error('prototypePhotoFileName') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="prototypePhotoFileType">Prototype Photo File Type</label>
            <select wire:model="prototypePhotoFileType" class="form-control" id="prototypePhotoFileType" required>
                <option value="">Select File Type</option>
                <option value="JPG">JPG</option>
                <option value="JPEG">JPEG</option>
                <option value="PNG">PNG</option>
                <option value="GIF">GIF</option>
            </select>
            @error('prototypePhotoFileType') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="prototypePhotoFile">Upload Prototype Photo File</label>
            <input wire:model="prototypePhotoFile" type="file" class="form-control-file" id="prototypePhotoFile" required>
            @error('prototypePhotoFile') <span class="error">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Submit Files</button>
    </form>
</div>

