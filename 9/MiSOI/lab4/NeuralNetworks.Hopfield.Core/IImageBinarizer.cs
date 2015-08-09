using System.Drawing;

namespace NeuralNetworks.Hopfield.Core
{
    public interface IImageBinarizer
    {
        bool[] ApplyBinarization(Bitmap bitMap);
    }
}
