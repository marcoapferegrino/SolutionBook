#include <stdio.h>
#include <stdlib.h>

int main()
{
	printf("Hola estoy platicando\n");
	printf("Hola segunda linea\n");
	switch (fork())
    {
        case -1:
            while ( true ){}
            break;
        case 0:
            /* Código del proceso hijo */
            ...
            break;
        default:
            ...
            /* Código del proceso original */
    }
	return 0;

	void *funcionDelHilo (void *parametro)
    {
       pthread_t idHilo;

       pthread_create (&idHilo, NULL, funcionDelThread, NULL);
    }

}