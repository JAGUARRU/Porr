<style>

*, *:before, *:after {
  box-sizing: border-box;
}
html {
    height: 100%;
}
body {
    height: 100%;
    padding: 10px;
}

a {
  color: #7e3af2 !important;
  text-decoration:none;
}
a:hover {
  color: #FFFFFF !important;
  text-decoration:none;
}

.text-wrapper {
    height: 100%;
   display: flex;
   flex-direction: column;
   align-items: center;
   justify-content: center;
}

.title {
    font-size: 5em;
    font-weight: 700;
    color: #7e3af2;
}

.subtitle {
    font-size: 40px;
    font-weight: 700;
    color: #1FA9D6;
}
.isi {
    font-size: 18px;
    text-align: center;
    margin:30px;
    padding:20px;
    color: white;
}
.buttons {
    margin: 30px;
        font-weight: 700;
        border: 2px solid #EE4B5E;
        text-decoration: none;
        padding: 15px;
        text-transform: uppercase;
        color: #EE4B5E;
        border-radius: 26px;
        transition: all 0.2s ease-in-out;
        display: inline-block;
        
        .buttons:hover {
            background-color: #EE4B5E;
            color: white;
            transition: all 0.2s ease-in-out;
        }
  }

</style>

<div class="text-wrapper">
    <div class="title" data-content="404">
        403 - การเข้าถึงถูกปฏิเสธ
    </div>

    <div class="subtitle">
        อุ๊ปส์! คุณไม่มีสิทธิ์เข้าถึงหน้านี้
    </div>

    <a class="button" href="{{ route('dashboard') }}">
        <div class="buttons">
            กลับไปหน้าหนัก
        </div>
    </a>
</div>