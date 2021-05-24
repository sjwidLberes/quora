<style>
    .block{
        width: 300px;
    }
    .maxhealth{
        width: 250px;
        background-color: #0f0f0f;
    }
    .health{
        width: 80%;
        height: 20px;
        background-color: #00a65a;
        color: #FFF;
    }
</style>

<div id="app">
<div class="block">
    <h1>YOU</h1>
    <div class="maxhealth"><div class="health" :style="{width: yourHealth + '%'}">@{{yourHealth}}</div></div>
</div>
<div class="block">
    <h1>Monster</h1>
    <div class="maxhealth"><div class="health" :style="{width: monsterHealth + '%'}">@{{monsterHealth}}</div></div>
</div>
    <div class="block" v-if="gameIsRun">
        <button @click="attack">Attack</button>
        <button>Cure</button>
        <button @click="giveup">GiveUp</button>
    </div>
    <div class="block" v-else>
        <button @click="start">StartGame</button>
    </div>
    <div class="block" v-for="arr in array">
        <ul>
            <li>你对怪兽造成了@{{ arr[0] }}点伤害</li>
            <li>怪兽对你造成了@{{ arr[1] }}点伤害</li>
        </ul>
    </div>

</div>




<script src="https://unpkg.com/vue"></script>
<script>
    var demo = new Vue({
        el: '#app',
        data: {
            monsterHealth: 100,
            yourHealth:100,
            takeDamage:0,
            getDamage:0,
            array:[],
            gameIsRun:false
        },
        methods:{
            start:function () {
              this.gameIsRun = !this.gameIsRun
            },
            attack:function () {
                this.takeDamage = this.damage(10)
                this.getDamage = this.damage(12)
                this.array.unshift([this.takeDamage,this.getDamage])
                this.monsterHealth -= this.takeDamage
                this.yourHealth -= this.getDamage
                if (this.monsterHealth <= 0){
                    alert('YOU WIN')
                    this.giveup()
                }
                if (this.yourHealth <= 0){
                    alert('YOU LOSE')
                    this.giveup()
                }

            },
            cure:function () {
                
            },
            giveup:function () {
                this.gameIsRun = false,
                    this.array=[],
                    this.monsterHealth = 100 ,
                    this.yourHealth = 100
            },
            damage:function (x) {
                return Math.round(Math.random()*x)
            }
        }
    })
</script>