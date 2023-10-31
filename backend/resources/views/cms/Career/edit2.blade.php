<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&amp;lang=en" />


<div class="container">
    <div class="title">Career</div>
    <form action="#">
        <div class="user-details">
            <div class="input-box">
                <span class="details">Position Name</span>
                <input type="text" class="form-control" id="positionName" name="name" value="{{ $career->name_position }}" required>
            </div>
            <div class="input-box">
                <span class="details">Location</span>
                <input type="text" class="form-control" id="positionName" name="name" value="{{ $career->name_position }}" required>
            </div>
            <div class="input-box">
                <span class="details">Description</span>
                <input type="text" class="form-control" id="positionName" name="name" value="{{ $career->name_position }}" required>
            </div>
            <div class="input-box">
                <span class="details">Responsibilities</span>
                <input type="text" class="form-control" id="positionName" name="name" value="{{ $career->name_position }}" required>
            </div>
        </div>

        <div class="gender-details">
            <span class="gender-title">Gender</span>
            <div class="category">
                <label for="">
                    <span class="dot one"></span>
                    <span class="gender">Female</span>
                </label>
                <label for="">
                    <span class="dot one"></span>
                    <span class="gender">Male</span>
                </label>
                <label for="">
                    <span class="dot one"></span>
                    <span class="gender">Prefer not to say</span>
                </label>
            </div>
        </div>
        <div class="button">
            <input type="submit" value="">
        </div>
    </form>
</div>


<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }
    body {
        
    }
</style>
