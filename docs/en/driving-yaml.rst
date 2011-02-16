Driving Imagine with YAML
=========================

I'm using Imagine to generate some images.
These images have some texts, some of these texts are static, some of them are dynamic.

I have managed to declare via YAML how I want my images to be generated.
I'm not generating very complex images, thought.


I've made this code working using symfony 1.4 on a Diem project, running on a PHP 5.3.3.

www.symfony-project.org
www.diem-project.org


Let's see the YAML definition:
-----------------------------
::

  image_generator.drawing:
    header:
      type: static_text           #static_text is used to write a text, driver will call drawStaticText
      text: My Funny Header       #the text to be drawn
      font: internal-2            #the font to use, defined later
      font-size: 20               #the font size
      font-color: [0, 0, 0]       #the font color
      font-alpha: 100             #the font alpha
      position: [5, 25]           #the position on the image
    name:
      type: dynamic               #dynamic tells to call a method named drawDynamicName
      font: internal-2
      font-size: 15
      font-color: [0, 0, 0]
      font-alpha: 100
      position: [200, 60]
    persons:
      type: dynamic
      font: internal-2
      font-color: [0, 0, 0]
      font-size: 12
      font-alpha: 100
      position: [150, 90]
    valide_date:
      type: dynamic
      font: internal-2
      font-size: 12
      font-color: [0, 0, 0]
      font-alpha: 100
      position: [150, 105]
    number:
      type: dynamic
      font: internal-2
      font-size: 12
      font-color: [0, 0, 0]
      font-alpha: 100
      position: [450, 100]
    bar_code:
      type: dynamic
      font: internal-2
      font-size: 12
      font-color: [0, 0, 0]
      font-alpha: 100
      position: [100, 120]

  fonts:
    internal-2: 2
    liberation-sans-serif: /usr/share/fonts/truetype/ttf-liberation/LiberationSerif-Italic.ttf


Then I have coded a class which uses all of these declarations to drive the image generation :
This class is still merged with some business things, perhaps I'll take some time to make it 
a standalone class.

Driving it:
----------

::

    protected function generate()
    {
      $this->imagine = new Imagine\Gd\Imagine();
    	$this->image = $this->imagine->create(500, 160, new Imagine\Color(array(171, 15, 41)));
    	//here I'm using Diem DIC to retrieve the stuff declared in YAML as an array
    	//but would be the same to load it using sfYaml::load($file) then getting image_generator.drawing key
    	$this->drawings = $this->container->getParameter('image_generator.drawing');
    	$this->draw($this->drawings);
    	$this->save();
    }

    protected function draw($drawings)
    {
    	foreach($this->drawings as $name => $drawing)
    	{
    		$drawing['font-object'] = $this->getFont($name, $drawing);
		    foreach($this->drawings as $name => $drawing)
        {
          $drawing['font-object'] = $this->getFont($name, $drawing);
          $this->{'draw' . dmString::camelize($drawing['type'])}($name, $drawing);
          //dmString::camelize('static_text') returns 'StaticText'
        }
    }

    //this is executed whenever a drawing is declared to be of type static_text
    //it simply ->draw() a ->text() on $this->image
    //using parameters given in $drawing 
    protected function drawStaticText($name, $drawing)
    {
      $this->image->draw()->text($this->container->get('i18n')->__($drawing['text'], array(), 'itSs'), $drawing['font-object'], new Imagine\Point($drawing['position'][0], $drawing['position'][1]));
    }
    
    //this is executed whenever a drawing is declared to be of type dynamic
    //it simply executes a method by generating is name by convention
    //$name = header will result in calling $this->drawDynamicHeader($drawing)
    protected function drawDynamic($name, $drawing)
    {
      $this->{'drawDynamic' . dmString::camelize($name)}($drawing);
    }

    protected function save()
    {
      $this->image->save(//compute path here);
    }

    public function getFont($name, $drawing)
    {
      return $this->getFontFor($drawing);
    }
  
    public function getFontFor($drawing)
    {
      return new Imagine\Font($this->getFontPath($drawing['font']), $drawing['font-size'], new Imagine\Color($drawing['font-color'], $drawing['font-alpha']));
    }
  
    public function getFontPath($name)
    {
      if(!isset($this->registeredFonts))
      {
        $this->registeredFonts = $this->container->getParameter('it_ss_fonts');
      }
      if(!isset($this->registeredFonts[$name]))
      {
        throw new \RuntimeException(sprintf('The font "%s" is not registered', $name));
      }
      return $this->registeredFonts[$name];
    }
    
    
That's it !