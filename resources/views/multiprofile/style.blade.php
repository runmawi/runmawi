<style>
    
    button.btn.btn-hover.ab {
        width:auto;
        color:#fff!important;
        margin-right:16px;
}
.sumbit_btn{
    display: flex;
    justify-content: center;
    padding: 25px;
}
.kid{
    color: #b1b1a2;
    font-family: inherit;
    font-size: small;
  
}
img#upfile1 {
    border-radius: 50%;
    height: auto;
    width: 34%;
}
p#upfile{
    margin-top: 1rem;
}
input#subuser_name {
    margin-bottom: 2rem;
}
.learn_more{
    float: left;
}
/* toggle switch */
.switch {
  position: relative;
  display: inline-block;
  width: 57px;
  height: 30px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 22px;
  width: 22px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #e09b1a;
}

input:focus + .slider {
  box-shadow: 0 0 1px #daa440;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
