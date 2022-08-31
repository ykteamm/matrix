<div class="header" style="background-color: blue;">
    <div class="top-nav-search" style="color:white;">
    <ul class="nav user-menu">

       <li class="nav-item dropdown has-arrow main-drop ml-md-3" style="cursor: pointer;">
          <a style="color:white;" onclick="hospitalc('click1','all')">Все</a>
          <a style="color:white;" onclick="hospitalc('click2','@h1%')">РНЦЭМП</a>
          <a style="color:white;" onclick="hospitalc('click3','@h2%')">РСНПМЦК</a>
          <a style="color:white;" onclick="hospitalc('click4','@h%')">РСНПМЦХ</a>   
       </li>
    </ul>

    </div>
    <ul class="nav user-menu">
       <li class="nav-item dropdown has-arrow main-drop ml-md-3" >
          <a href="{{ route('sign-in') }}" style="color:white;"><span class="fas fa-sign-in-alt" style="color:white;font-size: 20px;"></span></a>

       </li>
    </ul>
 </div>