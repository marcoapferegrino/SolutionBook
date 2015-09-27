<?php

namespace Illuminate\Foundation;

use Illuminate\Support\Collection;

class Inspiring
{
    /**
     * Get an inspiring quote.
     *
     * Taylor & Dayle made this commit from Jungfraujoch. (11,333 ft.)
     *
     * May McGinnis always control the board. #LaraconUS2015
     *
     * @return string
     */
    public static function quote()
    {
        return Collection::make([
            'No tengo miedo a los ordenadores. A lo que tengo miedo es a la falta de ellos." - Isaac Asimov',
            'Si usted quiere saber lo que una mujer dice realmente, mírela, no la escuche." - Oscar Wilde',
            'Y cuando empezamos a aprender este difícil oficio de vivir ya tenemos que morirnos." - Ernesto Sabato',
            'Puede que no haya ido a donde quería ir, pero creo que he terminado donde tenía que estar." - Douglas Adams',
            'A partir de ahora no viajaré más que en sueños." - Julio Verne',
            'Dont ever tell anybody anything. If you do, you start missing everybody." - J.D. Salinger',
            'Aquel que tiene un porqué para vivir se puede enfrentar a todos los "cómos"." - Friedrich Nietzsche',
            'Todo hombre tiene dos motivos para hacer las cosas, un buen motivo y el motivo real." - Anónimo',
            'La muerte no existe en contraposición a la vida sino como parte de ella." - Haruki Murakami',
            'Hay hombres que parecen tener sólo una idea y es una lástima que sea equivocada." - Charles Dickens',
            'Si quieres tener éxito, promete todo y no cumplas nada. - Napoleón Bonaparte'


        ])->random();
    }
}
