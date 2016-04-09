var iWidth = (document.body.clientWidth);
var iNumberBgSprite = Math.round((iWidth / 128) + 3);
var iBgSprite;
var iBgSpriteleft = 0;
var iSpriteLeft;
var iVanishLeft;
var iPosVanish;


// --------------------------------------------------------------génére la première bande en haut le ciel
for (iBgSprite = 1; iBgSprite < iNumberBgSprite; iBgSprite++) {
    document.write('<div class="theGround sky " style="left:' + iBgSpriteleft + 'px; background-Position:' + (Math.round(Math.random()*3)*-128) + 'px 0px;"></div>');
    iBgSpriteleft += 128;
}
iBgSpriteleft = 0; //On réinitialise la variable


var iSky = document.querySelectorAll('.sky');
function intervalSky() {
    for (var iPosSky = 0; iPosSky < iNumberBgSprite-1; iPosSky++) {
        iSpriteLeft = (parseInt(iSky.item(iPosSky).style.left));
        iSpriteLeft--;
        if(iSpriteLeft == -128){
            iSpriteLeft = (iNumberBgSprite * 128) -256;
            iSky.item(iPosSky).style.backgroundPosition = (Math.round(Math.random()*3)*-128) + 'px 0px';
        }
        iSky.item(iPosSky).style.left = iSpriteLeft + 'px';
    }
}


// --------------------------------------------------------------génére la Deuxieme bande l'horizon

for (iBgSprite = 1; iBgSprite < iNumberBgSprite; iBgSprite++) {
    document.write('<div class="theGround vanish" style="left:' + iBgSpriteleft + 'px; background-Position:' + (Math.round(Math.random()*3)*-128) + 'px -128px;"></div>');
    iBgSpriteleft += 128;
}
iBgSpriteleft = 0; //On réinitialise la variable

var iVanish = document.querySelectorAll('.vanish');
function intervalVanish() {
    for (iPosVanish = 0; iPosVanish < iNumberBgSprite-1; iPosVanish++) {
        iVanishLeft = (parseInt(iVanish.item(iPosVanish).style.left));
        iVanishLeft--;
        if(iVanishLeft == -128){
            iVanishLeft = (iNumberBgSprite * 128) -256;
            iVanish.item(iPosVanish).style.backgroundPosition = (Math.round(Math.random()*3)*-128) + 'px -128px';
        }
        iVanish.item(iPosVanish).style.left = iVanishLeft + 'px';

    }
}

// --------------------------------------------------------------génére la Troisième Bande la mer
for (iBgSprite = 1; iBgSprite < iNumberBgSprite; iBgSprite++) {
    document.write('<div class="theGround sea " style="left:' + iBgSpriteleft + 'px"></div>');
    iBgSpriteleft += 128;
}
iBgSpriteleft = 0; //On réinitialise la variable

var iSea = document.querySelectorAll('.sea');
function intervalSea() {
    for (var iPos = 0; iPos < iNumberBgSprite-1; iPos++) {
        iSpriteLeft = (parseInt(iSea.item(iPos).style.left));
        iSpriteLeft--;
        if(iSpriteLeft == -128){
            iSpriteLeft = (iNumberBgSprite * 128) -256;
        }
        iSea.item(iPos).style.left = iSpriteLeft + 'px';
    }
}

// le Heros ---------------------------------------------------------------------------------------------------
document.write('<div id="heros"></div>');

var oHeros = document.querySelector('#heros');
var iKeyFrameHeros = 0;// 0 * -40 * -80 * -120 * -160 * -200 * -240 * -280 !!!

function intervalFrame() {  // fait défiler les Frames du Personnage 8 x 40
    iKeyFrameHeros -= 40;
    if (iKeyFrameHeros < -280) {
        iKeyFrameHeros = 0;
    }
    oHeros.style.backgroundPosition = iKeyFrameHeros + "px 0px";
}

// --------------------------------------------------------------génére la 4eme Bande la route

for (iBgSprite = 1; iBgSprite < iNumberBgSprite; iBgSprite++) {
    var iRoadSprite = -384;
    var iRandomBg = Math.round(Math.random()*10);
    if(iRandomBg > 7){ // si superieur a 7 Génère un buisson
        iRoadSprite = -256;
    }

    document.write('<div class="theGround road " style="left:' + iBgSpriteleft + 'px; background-Position:' + iRoadSprite + 'px -384px;""></div>');
    iBgSpriteleft += 128;
}
iBgSpriteleft = 0; //On réinitialise la variable


var iRoad = document.querySelectorAll('.road');
function intervalRoad() {

    for (var iPos = 0; iPos < iNumberBgSprite-1; iPos++) {
        iSpriteLeft = (parseInt(iRoad.item(iPos).style.left));
        iSpriteLeft--;
        if(iSpriteLeft == -128){
            iSpriteLeft = (iNumberBgSprite * 128) -256;
            iRoadSprite = -384;
            iRandomBg = Math.round(Math.random()*10);
            if(iRandomBg > 7){ // si superieur a 7 Génère un buisson
                iRoadSprite = -256;
            }
            iRoad.item(iPos).style.backgroundPosition = iRoadSprite + 'px -384px';
        }
        iRoad.item(iPos).style.left = iSpriteLeft + 'px';

    }
}

var iSpeed = 2;

window.setInterval("intervalSky()", 1000 / (iSpeed*10)); // On fait defiler le ciel
window.setInterval("intervalVanish()", 1000 / (iSpeed*20)); // On fait defiler l'horizon
window.setInterval("intervalSea()", 1000 / (iSpeed*30)); // On fait defiler la mer
window.setInterval("intervalFrame()", 1000 / (iSpeed*12)); // fait defiler le Heros
window.setInterval("intervalRoad()", 1000 / (iSpeed*60)); // On fait defiler la route














